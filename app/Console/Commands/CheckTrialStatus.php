<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Notifications\TrialExpired;
use App\Notifications\TrialExpiring;
use Illuminate\Console\Command;

class CheckTrialStatus extends Command
{
    protected $signature = 'check:trials';
    protected $description = 'Check trial subscriptions status and send notifications';

    public function handle()
    {
        // Send trial expiring notifications
        Subscription::query()
            ->where('is_trial', true)
            ->where('trial_converted', false)
            ->where('trial_expiring_sent', false)
            ->where('ends_at', '<=', now()->addDays(2))
            ->each(function ($subscription) {
                $instance = $subscription->instance;
                $instance->user->notify(new TrialExpiring($instance));
                $subscription->update(['trial_expiring_sent' => true]);
            });

        // Handle expired trials
        Subscription::query()
            ->where('is_trial', true)
            ->where('trial_converted', false)
            ->where('trial_expired_sent', false)
            ->where('ends_at', '<', now())
            ->each(function ($subscription) {
                $instance = $subscription->instance;
                if ($instance->status === 'active') {
                    $instance->update([
                        'status' => 'suspended',
                        'suspended_at' => now(),
                        'suspension_reason' => 'Trial expired'
                    ]);
                }
                $instance->user->notify(new TrialExpired($instance));
                $subscription->update(['trial_expired_sent' => true]);
            });

        $this->info('Trial status checked successfully.');
    }
} 