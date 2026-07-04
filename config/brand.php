<?php

/*
|--------------------------------------------------------------------------
| Brand / White-label Configuration
|--------------------------------------------------------------------------
|
| Single source of truth for branding. Rebranding a cloned project for a new
| client should only require editing this file (or the matching .env keys) —
| never the Blade components or layouts.
|
| Colour scales are injected as CSS custom properties by the layout
| (see resources/views/components/brand-styles.blade.php), overriding the
| Tailwind @theme defaults. That is why utilities like `bg-brand-500` or
| `text-accent-600` recolour automatically when these values change.
|
*/

return [
    'app_name' => env('APP_NAME', 'Febrian Kit'),

    'logo_text' => env('BRAND_LOGO_TEXT', env('APP_NAME', 'Febrian Kit')),

    // Path (relative to public/) to a logo image. When null, `logo_text` is shown.
    'logo_path' => env('BRAND_LOGO_PATH'),

    'favicon' => env('BRAND_FAVICON', '/favicon.ico'),

    // Convenience single-colour tokens (kept in sync with the 500 shades below).
    'primary_color' => env('BRAND_PRIMARY_COLOR', '#ff6d01'),
    'secondary_color' => env('BRAND_SECONDARY_COLOR', '#0284c7'),
    'accent_color' => env('BRAND_ACCENT_COLOR', '#06b6d4'),

    /*
    | Full colour scales — used to generate the runtime CSS variables.
    | brand   = primary (Febrian orange by default)
    | accent  = secondary / informational (blue → cyan) for charts & secondary CTAs
    */
    'colors' => [
        'brand' => [
            50 => '#fff7ed',
            100 => '#ffedd5',
            200 => '#fed7aa',
            300 => '#fdba74',
            400 => '#fb923c',
            500 => '#ff6d01',
            600 => '#ea580c',
            700 => '#c2410c',
            800 => '#9a3412',
            900 => '#7c2d12',
            950 => '#431407',
        ],

        'accent' => [
            50 => '#ecfeff',
            100 => '#cffafe',
            200 => '#a5f3fc',
            300 => '#67e8f9',
            400 => '#22d3ee',
            500 => '#06b6d4',
            600 => '#0891b2',
            700 => '#0e7490',
            800 => '#155e75',
            900 => '#164e63',
            950 => '#083344',
        ],
    ],
];
