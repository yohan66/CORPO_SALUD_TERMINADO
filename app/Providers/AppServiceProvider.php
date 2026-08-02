<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Bien;
use App\Observers\BienObserver;

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
        Bien::observe(BienObserver::class);
    }
}
