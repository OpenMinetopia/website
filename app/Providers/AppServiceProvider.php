<?php

namespace App\Providers;

use App\Models\Instance;
use App\Observers\InstanceDeploymentObserver;
use App\Observers\InstanceObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Instance::observe(InstanceObserver::class);
        Instance::observe(InstanceDeploymentObserver::class);
    }
}
