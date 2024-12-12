<?php

namespace App\Services;

use App\Models\Instance;
use App\Models\PloiSettings;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PloiService
{
    protected $baseUrl = 'https://ploi.io/api';
    protected $settings;

    public function __construct()
    {
        $this->settings = PloiSettings::first();
    }

    protected function getHeaders()
    {
        if (!$this->settings || !$this->settings->api_token) {
            throw new \Exception('Ploi API token not configured');
        }

        return [
            'Authorization' => 'Bearer ' . $this->settings->api_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'User-Agent' => config('app.name')
        ];
    }

    public function deploy(Instance $instance)
    {
        try {
            \Log::info('Starting deployment process', ['instance' => $instance->hostname]);

            // 1. Check/Create Site
            if (!$instance->ploi_site_id) {
                if (!$this->createSite($instance)) {
                    throw new \Exception('Failed to create site');
                }
            }

            // 2. Get site details to check current status
            $siteDetails = $this->getSiteDetails($instance);
            if (!$siteDetails) {
                throw new \Exception('Failed to get site details');
            }

            // 3. Install repository if not installed
            if (!($siteDetails['has_repository'] ?? false)) {
                if (!$this->installRepository($instance)) {
                    throw new \Exception('Failed to install repository');
                }
                // Wait for repository to be cloned
                sleep(2);
            }

            // 4. Create database if not exists
            if (!$instance->ploi_database_name) {
                if (!$this->createDatabase($instance)) {
                    throw new \Exception('Failed to create database');
                }
            }

            // 5. Update deployment script
            if (!$this->updateDeploymentScript($instance)) {
                throw new \Exception('Failed to update deployment script');
            }

            // 6. Request SSL if not enabled
            if (!$instance->ploi_ssl_enabled) {
                if (!$this->requestSsl($instance)) {
                    throw new \Exception('Failed to request SSL certificate');
                }
            }

            // 7. Update environment variables
            if (!$this->updateEnvironmentVariables($instance)) {
                throw new \Exception('Failed to update environment variables');
            }

            // 8. Trigger deployment
            if (!$this->triggerDeployment($instance)) {
                throw new \Exception('Failed to trigger deployment');
            }

            // Update instance status to show deployment is complete and instance is active
            $instance->update([
                'ploi_deployment_status' => 'completed',
                'deployment_status' => 'completed',
                'status' => 'active',  // Set instance to active
                'last_deployment_at' => now()
            ]);

            return true;

        } catch (\Exception $e) {
            \Log::error('Deployment failed', [
                'instance' => $instance->hostname,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $instance->update([
                'ploi_deployment_status' => 'failed',
                'ploi_deployment_error' => $e->getMessage()
            ]);

            return false;
        }
    }

    protected function getSiteDetails(Instance $instance)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->get("{$this->baseUrl}/servers/{$instance->ploi_server_id}/sites/{$instance->ploi_site_id}");

            if (!$response->successful()) {
                throw new \Exception('Failed to get site details');
            }

            return $response->json()['data'] ?? null;
        } catch (\Exception $e) {
            \Log::error('Failed to get site details', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    protected function installRepository(Instance $instance)
    {
        try {
            \Log::info('Installing repository', ['instance' => $instance->hostname]);

            // Parse repository URL to get the name format
            $repoUrl = $this->settings->repository_url;
            if (!preg_match('/github\.com\/([^\/]+\/[^\/\.]+)(?:\.git)?$/', $repoUrl, $matches)) {
                throw new \Exception('Invalid repository URL format');
            }
            $repoName = $matches[1];

            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/servers/{$instance->ploi_server_id}/sites/{$instance->ploi_site_id}/repository", [
                    'provider' => 'github',
                    'branch' => $this->settings->repository_branch,
                    'name' => $repoName
                ]);

            if (!$response->successful()) {
                throw new \Exception($response->json()['message'] ?? 'Failed to install repository');
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Repository installation failed', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    protected function updateDeploymentScript(Instance $instance)
    {
        try {
            \Log::info('Updating deployment script', ['instance' => $instance->hostname]);

            $deploymentScript = <<<BASH
cd /home/ploi/{$instance->hostname}

# Pull latest changes
git pull origin {$this->settings->repository_branch}

# Install/update PHP dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Put application in maintenance mode
php artisan down

# Run database migrations first
php artisan migrate --force

# Install/update Node dependencies and build assets
npm ci
npm run build

# Reload PHP-FPM (using PHP 8.4)
echo "" | sudo -S service php8.4-fpm reload

# Now clear and rebuild caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Restart queue workers
php artisan queue:restart

# Optimize application
php artisan optimize:clear
php artisan optimize

# Exit maintenance mode
php artisan up

echo "🚀 Application deployed!"
BASH;

            $response = Http::withHeaders($this->getHeaders())
                ->patch("{$this->baseUrl}/servers/{$instance->ploi_server_id}/sites/{$instance->ploi_site_id}/deploy/script", [
                    'deploy_script' => $deploymentScript
                ]);

            if (!$response->successful()) {
                \Log::error('Failed to update deployment script', [
                    'response' => $response->json(),
                    'status' => $response->status(),
                    'url' => "{$this->baseUrl}/servers/{$instance->ploi_server_id}/sites/{$instance->ploi_site_id}/deploy/script"
                ]);
                throw new \Exception($response->json()['message'] ?? 'Failed to update deployment script');
            }

            \Log::info('Deployment script updated successfully');
            return true;

        } catch (\Exception $e) {
            \Log::error('Failed to update deployment script', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'instance' => $instance->hostname
            ]);
            return false;
        }
    }

    protected function triggerDeployment(Instance $instance)
    {
        try {
            \Log::info('Triggering deployment', ['instance' => $instance->hostname]);

            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/servers/{$instance->ploi_server_id}/sites/{$instance->ploi_site_id}/deploy");

            if (!$response->successful()) {
                \Log::error('Failed to trigger deployment', [
                    'response' => $response->json(),
                    'status' => $response->status()
                ]);
                throw new \Exception($response->json()['message'] ?? 'Failed to trigger deployment');
            }

            \Log::info('Deployment triggered successfully');
            return true;

        } catch (\Exception $e) {
            \Log::error('Failed to trigger deployment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    protected function requestSsl(Instance $instance)
    {
        try {
            \Log::info('Requesting SSL certificate', ['instance' => $instance->hostname]);

            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/servers/{$instance->ploi_server_id}/sites/{$instance->ploi_site_id}/certificates", [
                    'type' => 'letsencrypt',
                    'certificate' => $instance->hostname // domain for Let's Encrypt
                ]);

            if (!$response->successful()) {
                \Log::error('Failed to request SSL certificate', [
                    'response' => $response->json(),
                    'status' => $response->status(),
                    'instance' => $instance->hostname
                ]);
                throw new \Exception($response->json()['message'] ?? 'Failed to request SSL certificate');
            }

            // Update instance SSL status
            $instance->update([
                'ploi_ssl_enabled' => true
            ]);

            \Log::info('SSL certificate requested successfully', [
                'instance' => $instance->hostname,
                'response' => $response->json()
            ]);

            // Wait a moment for SSL to be processed
            sleep(2);

            return true;
        } catch (\Exception $e) {
            \Log::error('SSL certificate request failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'instance' => $instance->hostname
            ]);
            return false;
        }
    }

    protected function updateEnvironmentVariables(Instance $instance)
    {
        try {
            \Log::info('Updating environment variables', ['instance' => $instance->hostname]);

            // First get current .env content
            $response = Http::withHeaders($this->getHeaders())
                ->get("{$this->baseUrl}/servers/{$instance->ploi_server_id}/sites/{$instance->ploi_site_id}/env");

            if (!$response->successful()) {
                throw new \Exception('Failed to get current environment configuration');
            }

            $currentEnv = $response->json()['content'] ?? '';
            $envArray = $this->parseEnvToArray($currentEnv);

            // Generate new APP_KEY if not present
            if (empty($envArray['APP_KEY'])) {
                $envArray['APP_KEY'] = 'base64:' . base64_encode(random_bytes(32));
            }

            // Update required variables
            $updatedVars = [
                'APP_NAME' => "\"{$instance->hostname}\"",
                'APP_ENV' => 'production',
                'APP_DEBUG' => 'false',
                'APP_URL' => "https://{$instance->hostname}",
                'APP_KEY' => $envArray['APP_KEY'],

                // Database - using IP instead of localhost
                'DB_CONNECTION' => 'mysql',
                'DB_HOST' => '127.0.0.1',
                'DB_PORT' => '3306',
                'DB_DATABASE' => $instance->ploi_database_name,
                'DB_USERNAME' => $instance->ploi_database_user,
                'DB_PASSWORD' => $instance->ploi_database_password,

                // API Keys
                'MINECRAFT_API_KEY' => $instance->instance_api_token,
                'PLUGIN_API_KEY' => $instance->plugin_api_token,
                'MC_SERVER_ADDRESS' => $instance->minecraft_server_host,
                'PLUGIN_API_URL' => "http://{$instance->minecraft_plugin_ip}",

                // Queue and Session
                'QUEUE_CONNECTION' => 'database',
                'SESSION_DRIVER' => 'file',
                'SESSION_LIFETIME' => '120',

                // Cache and Filesystem
                'CACHE_DRIVER' => 'file',
                'FILESYSTEM_DISK' => 'local',
            ];

            // Merge with existing env, preserving other variables
            $envArray = array_merge($envArray, $updatedVars);

            // Convert back to .env format
            $envContent = $this->arrayToEnvFormat($envArray);

            // Update the .env file
            $response = Http::withHeaders($this->getHeaders())
                ->put("{$this->baseUrl}/servers/{$instance->ploi_server_id}/sites/{$instance->ploi_site_id}/env", [
                    'content' => $envContent
                ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to update environment configuration');
            }

            \Log::info('Environment variables updated successfully');
            return true;

        } catch (\Exception $e) {
            \Log::error('Failed to update environment variables', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'instance' => $instance->hostname
            ]);
            return false;
        }
    }

    protected function parseEnvToArray(string $envContent): array
    {
        $envArray = [];
        $lines = explode("\n", $envContent);

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip empty lines and comments
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }

            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Remove quotes if present
                if (preg_match('/^(["\'])(.*)\1$/', $value, $matches)) {
                    $value = $matches[2];
                }

                $envArray[$key] = $value;
            }
        }

        return $envArray;
    }

    protected function arrayToEnvFormat(array $envArray): string
    {
        $content = '';

        // Application
        $content .= "# Application Settings\n";
        foreach (['APP_NAME', 'APP_ENV', 'APP_KEY', 'APP_DEBUG', 'APP_URL'] as $key) {
            if (isset($envArray[$key])) {
                $content .= "{$key}={$envArray[$key]}\n";
            }
        }

        // Database
        $content .= "\n# Database Configuration\n";
        foreach (['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'] as $key) {
            if (isset($envArray[$key])) {
                $content .= "{$key}={$envArray[$key]}\n";
            }
        }

        // API Keys
        $content .= "\n# API Configuration\n";
        foreach (['MINECRAFT_API_KEY', 'PLUGIN_API_KEY'] as $key) {
            if (isset($envArray[$key])) {
                $content .= "{$key}={$envArray[$key]}\n";
            }
        }

        // Add remaining variables
        $standardKeys = [
            'APP_NAME', 'APP_ENV', 'APP_KEY', 'APP_DEBUG', 'APP_URL',
            'DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD',
            'MINECRAFT_API_KEY', 'PLUGIN_API_KEY'
        ];

        $remainingVars = array_diff_key($envArray, array_flip($standardKeys));
        if (!empty($remainingVars)) {
            $content .= "\n# Additional Configuration\n";
            foreach ($remainingVars as $key => $value) {
                $content .= "{$key}={$value}\n";
            }
        }

        return $content;
    }

    public function getServers()
    {
        try {
            if (!$this->settings || !$this->settings->api_token) {
                return [];
            }

            \Log::info('Fetching Ploi servers');

            $response = Http::withHeaders($this->getHeaders())
                ->get("{$this->baseUrl}/servers");

            if (!$response->successful()) {
                \Log::error('Failed to fetch servers', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                throw new \Exception('Failed to fetch servers from Ploi');
            }

            \Log::info('Successfully fetched servers', [
                'count' => count($response->json()['data'] ?? [])
            ]);

            return $response->json()['data'] ?? [];
        } catch (\Exception $e) {
            \Log::error('Error fetching servers', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }

    protected function createSite(Instance $instance)
    {
        try {
            \Log::info('Creating new site', ['instance' => $instance->hostname]);

            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/servers/{$instance->ploi_server_id}/sites", [
                    'domain' => $instance->hostname,
                    'root_domain' => $instance->hostname,
                    'web_directory' => '/public',
                    'php_version' => '8.4',
                    'systemuser' => 'ploi'
                ]);

            if (!$response->successful()) {
                \Log::error('Failed to create site', [
                    'response' => $response->json(),
                    'status' => $response->status(),
                    'domain' => $instance->hostname
                ]);
                throw new \Exception($response->json()['message'] ?? 'Failed to create site');
            }

            $siteData = $response->json()['data'];

            // Update instance with site ID
            $instance->update([
                'ploi_site_id' => $siteData['id']
            ]);

            \Log::info('Site created successfully', [
                'site_id' => $siteData['id'],
                'domain' => $instance->hostname
            ]);

            // Wait a moment for site to be ready
            sleep(2);

            return true;
        } catch (\Exception $e) {
            \Log::error('Site creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'instance' => $instance->hostname
            ]);

            $instance->update([
                'ploi_deployment_status' => 'failed',
                'ploi_deployment_error' => $e->getMessage()
            ]);
            return false;
        }
    }

    protected function createDatabase(Instance $instance)
    {
        try {
            \Log::info('Creating database', ['instance' => $instance->hostname]);

            // Generate unique database name and credentials
            $uniqueId = $instance->id . '_' . uniqid();
            $dbName = Str::slug($instance->hostname . '_' . $uniqueId, '_');
            $dbUser = Str::slug($instance->hostname . '_user_' . $uniqueId, '_');
            $dbPass = Str::random(32);

            // Ensure names aren't too long for MySQL
            $dbName = substr($dbName, 0, 32);
            $dbUser = substr($dbUser, 0, 32);

            $response = Http::withHeaders($this->getHeaders())
                ->post("{$this->baseUrl}/servers/{$instance->ploi_server_id}/databases", [
                    'name' => $dbName,
                    'user' => $dbUser,
                    'password' => $dbPass
                ]);

            if (!$response->successful()) {
                \Log::error('Failed to create database', [
                    'response' => $response->json(),
                    'status' => $response->status(),
                    'database' => $dbName
                ]);
                throw new \Exception($response->json()['message'] ?? 'Failed to create database');
            }

            // Store database credentials in instance
            $instance->update([
                'ploi_database_name' => $dbName,
                'ploi_database_user' => $dbUser,
                'ploi_database_password' => $dbPass
            ]);

            \Log::info('Database created successfully', [
                'database' => $dbName,
                'instance' => $instance->hostname
            ]);

            // Wait a moment for database to be ready
            sleep(2);

            return true;
        } catch (\Exception $e) {
            \Log::error('Database creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'instance' => $instance->hostname
            ]);

            $instance->update([
                'ploi_deployment_status' => 'failed',
                'ploi_deployment_error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
