<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Site ayarına eriş: setting('contact_phone', '0212 ...')
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}
