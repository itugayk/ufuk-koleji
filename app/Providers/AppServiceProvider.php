<?php

namespace App\Providers;

use App\Models\Level;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::setLocale('tr');

        // Layout (ve içine alınan navbar/footer) için ortak veriler.
        View::composer('components.layouts.app', function ($view) {
            $view->with('siteSettings', Setting::map());
            $view->with('navLevels', Level::active()->get());
        });
    }
}
