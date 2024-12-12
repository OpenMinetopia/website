<?php

namespace App\Jobs;

use App\Models\Instance;
use App\Models\PloiSettings;
use App\Services\PloiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DeployInstance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 600;

    public function __construct(public Instance $instance)
    {
    }

    public function handle()
    {
        try {
            // Get Ploi settings
            $settings = PloiSettings::first();
            if (!$settings || !$settings->default_server_id) {
                throw new \Exception('Default deployment server not configured in settings');
            }

            // Set server ID from settings
            $this->instance->update([
                'ploi_server_id' => $settings->default_server_id
            ]);

            // Start deployment
            $deployed = app(PloiService::class)->deploy($this->instance);

            if ($deployed) {
                // Send success notification to Discord
                $this->sendDiscordNotification('✅ Deployment Completed', 'success');
                
                try {
                    // Send activation notification to user
                    $this->instance->user->notify(new \App\Notifications\InstanceActivated($this->instance));
                } catch (\Exception $e) {
                    Log::error('Failed to send activation email', [
                        'error' => $e->getMessage(),
                        'instance' => $this->instance->hostname
                    ]);
                    // Don't fail the deployment just because email failed
                }
            } else {
                $this->handleDeploymentFailure('Deployment failed');
            }
        } catch (\Exception $e) {
            Log::error('Deployment failed', [
                'error' => $e->getMessage(),
                'instance' => $this->instance->hostname,
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->handleDeploymentFailure($e->getMessage());
        }
    }

    private function handleDeploymentFailure(string $error)
    {
        // Only send notification if status is changing to failed
        if ($this->instance->deployment_status !== 'failed') {
            // Update instance status
            $this->instance->update([
                'deployment_status' => 'failed',
                'ploi_deployment_status' => 'failed',
                'ploi_deployment_error' => $error
            ]);

            // Send Discord notification only once
            $this->sendDiscordNotification('❌ Deployment Failed', 'error', $error);

            try {
                // Send notification to user
                $this->instance->user->notify(new \App\Notifications\DeploymentFailed($this->instance));
            } catch (\Exception $e) {
                Log::error('Failed to send failure email', [
                    'error' => $e->getMessage(),
                    'instance' => $this->instance->hostname
                ]);
                // Don't fail the error handling just because email failed
            }
        }
    }

    private function sendDiscordNotification(string $title, string $type, string $error = null)
    {
        $color = match($type) {
            'success' => '57F287', // Discord green
            'error' => 'ED4245',   // Discord red
            'info' => '5865F2',    // Discord blue
            default => '5865F2'
        };

        $fields = [
            [
                'name' => 'Portal URL',
                'value' => "https://{$this->instance->hostname}",
                'inline' => true
            ],
            [
                'name' => 'Owner',
                'value' => $this->instance->user->name,
                'inline' => true
            ]
        ];

        if ($error) {
            array_unshift($fields, [
                'name' => 'Error',
                'value' => $error,
                'inline' => false
            ]);
        }

        Http::post(config('services.discord.webhook_url'), [
            'embeds' => [[
                'title' => $title,
                'description' => "Instance: {$this->instance->hostname}",
                'color' => hexdec($color),
                'fields' => $fields,
                'url' => route('filament.admin.resources.instances.edit', $this->instance),
                'timestamp' => now()->toIso8601String()
            ]]
        ]);
    }
} 