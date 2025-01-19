<?php

namespace App\Providers;

use App\Models\SiteSettings;
use Illuminate\Support\Facades\View;
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
    public function boot()
    {
        $siteSetting = SiteSettings::first();
        View::share('siteSetting', $siteSetting);
    }
}
