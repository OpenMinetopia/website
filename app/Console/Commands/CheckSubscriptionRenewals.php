<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Notifications\SubscriptionRenewalReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckSubscriptionRenewals extends Command
{
    protected $signature = 'subscriptions:check-renewals';
    protected $description = 'Check for subscriptions that need renewal notifications';

    public function handle()
    {
        // Check for subscriptions expiring in 7 days
        Subscription::query()
            ->where('status', 'paid')
            ->where('ends_at', '>', now())
            ->where('ends_at', '<=', now()->addDays(7))
            ->where('renewal_7_days_sent', false)
            ->each(function ($subscription) {
                $subscription->instance->user->notify(new SubscriptionRenewalReminder($subscription, 7));
                $subscription->update(['renewal_7_days_sent' => true]);
            });

        // Check for subscriptions expiring in 2 days
        Subscription::query()
            ->where('status', 'paid')
            ->where('ends_at', '>', now())
            ->where('ends_at', '<=', now()->addDays(2))
            ->where('renewal_2_days_sent', false)
            ->each(function ($subscription) {
                $subscription->instance->user->notify(new SubscriptionRenewalReminder($subscription, 2));
                $subscription->update(['renewal_2_days_sent' => true]);
            });

        // Check for subscriptions expiring today
        Subscription::query()
            ->where('status', 'paid')
            ->whereDate('ends_at', now()->toDateString())
            ->where('renewal_today_sent', false)
            ->each(function ($subscription) {
                $subscription->instance->user->notify(new SubscriptionRenewalReminder($subscription, 0));
                $subscription->update(['renewal_today_sent' => true]);
            });

        // Suspend expired instances
        Subscription::query()
            ->where('status', 'paid')
            ->where('ends_at', '<', now())
            ->each(function ($subscription) {
                $instance = $subscription->instance;
                if ($instance && $instance->status === 'active') {
                    $instance->update([
                        'status' => 'suspended',
                        'suspended_at' => now(),
                        'suspension_reason' => 'Subscription expired'
                    ]);
                }
            });

        $this->info('Subscription renewals checked successfully.');
    }
} 