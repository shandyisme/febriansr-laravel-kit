<?php

use Illuminate\Support\Arr;

if (! function_exists('brand')) {
    /**
     * Read a value from the brand configuration.
     *
     *   brand()                 → the whole brand config array
     *   brand('app_name')       → 'Febrian Kit'
     *   brand('colors.brand.500') → '#ff6d01'
     *   brand('missing', 'x')   → 'x'
     */
    function brand(?string $key = null, mixed $default = null): mixed
    {
        $config = config('brand', []);

        if ($key === null) {
            return $config;
        }

        return Arr::get($config, $key, $default);
    }
}
