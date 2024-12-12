<?php

namespace App\Observers;

use App\Models\Instance;
use App\Services\PloiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstanceDeploymentObserver
{
    public function updated(Instance $instance)
    {
        // Log the conditions for debugging
        Log::info('Instance updated, checking deployment conditions', [
            'instance_id' => $instance->id,
            'status' => $instance->status,
            'dns_verified' => $instance->dns_verified,
            'has_set_api_tokens' => $instance->has_set_api_tokens,
            'deployment_status' => $instance->deployment_status,
            'original_deployment_status' => $instance->getOriginal('deployment_status'),
            'should_deploy' => $this->shouldStartDeployment($instance)
        ]);

        // Check if conditions are met for deployment
        if ($this->shouldStartDeployment($instance)) {
            Log::info('Starting deployment for instance', ['instance_id' => $instance->id]);

            // Update status to show we're working on it
            $instance->forceFill([
                'deployment_status' => 'in_progress'
            ])->save();

            // Send "Starting Deployment" notification to Discord
            Http::post(config('services.discord.webhook_url'), [
                'embeds' => [[
                    'title' => '🚀 Starting Deployment',
                    'description' => "Starting deployment for {$instance->hostname}",
                    'color' => hexdec('5865F2'), // Discord blue
                    'fields' => [
                        [
                            'name' => 'Portal URL',
                            'value' => "https://{$instance->hostname}",
                            'inline' => true
                        ],
                        [
                            'name' => 'Owner',
                            'value' => $instance->user->name,
                            'inline' => true
                        ]
                    ],
                    'url' => route('filament.admin.resources.instances.edit', $instance),
                    'timestamp' => now()->toIso8601String()
                ]]
            ]);

            // Trigger deployment in background using a proper queue
            dispatch(new \App\Jobs\DeployInstance($instance))
                ->onQueue('deployments')
                ->delay(now()->addSeconds(5));
        }

        // Check if deployment just failed
        if ($instance->isDirty('deployment_status') && 
            $instance->deployment_status === 'failed' &&
            $instance->getOriginal('deployment_status') !== 'failed') 
        {
            $this->sendFailureNotification($instance);
        }
    }

    private function shouldStartDeployment(Instance $instance): bool
    {
        // More explicit conditions with logging
        $conditions = [
            'status_is_pending' => $instance->status === 'pending',
            'dns_is_verified' => $instance->dns_verified,
            'api_tokens_configured' => $instance->has_set_api_tokens,
            'deployment_uncompleted' => $instance->deployment_status === 'uncompleted',
            'not_currently_deploying' => !in_array($instance->getOriginal('deployment_status'), ['in_progress', 'completed', 'failed'])
        ];

        Log::info('Checking deployment conditions', [
            'instance_id' => $instance->id,
            'conditions' => $conditions
        ]);

        return $conditions['status_is_pending'] && 
               $conditions['dns_is_verified'] && 
               $conditions['api_tokens_configured'] && 
               $conditions['deployment_uncompleted'] && 
               $conditions['not_currently_deploying'];
    }

    private function sendFailureNotification(Instance $instance)
    {
        Http::post(config('services.discord.webhook_url'), [
            'embeds' => [[
                'title' => '❌ Deployment Failed',
                'description' => "Deployment failed for {$instance->hostname}",
                'color' => hexdec('FF0000'),
                'fields' => [
                    [
                        'name' => 'Error',
                        'value' => $instance->ploi_deployment_error ?? 'Unknown error',
                        'inline' => false
                    ],
                    [
                        'name' => 'Portal URL',
                        'value' => "https://{$instance->hostname}",
                        'inline' => true
                    ],
                    [
                        'name' => 'Owner',
                        'value' => $instance->user->name,
                        'inline' => true
                    ]
                ],
                'url' => route('filament.admin.resources.instances.edit', $instance),
                'timestamp' => now()->toIso8601String()
            ]]
        ]);
    }
} 