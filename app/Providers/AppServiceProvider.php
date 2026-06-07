<?php

namespace App\Providers;

use App\Models\Level;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
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

        // Üretimde (https APP_URL) tüm üretilen bağlantıları https yap — mixed-content engellenir.
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        // Layout (ve içine alınan navbar/footer) için ortak veriler.
        View::composer('components.layouts.app', function ($view) {
            $view->with('siteSettings', Setting::map());
            $view->with('navLevels', Level::active()->get());
        });
    }
}
