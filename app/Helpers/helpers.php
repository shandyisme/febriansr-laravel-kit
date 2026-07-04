<?php

use App\Models\Setting;
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

if (! function_exists('setting_cache')) {
    /**
     * Internal per-request cache accessor for settings.
     *
     * Holds the loaded [key => casted value] map for the current request so
     * setting() only hits the database once. Pass a false-y sentinel to flush.
     *
     * @internal Used by setting() and setting_set(); not part of the public API.
     *
     * @return array<string, mixed>|null
     */
    function setting_cache(?array $set = null, bool $flush = false): ?array
    {
        static $cache = null;

        if ($flush) {
            $cache = null;

            return null;
        }

        if ($set !== null) {
            $cache = $set;
        }

        return $cache;
    }
}

if (! function_exists('setting_cast')) {
    /**
     * Cast a raw stored setting value into its typed PHP representation.
     */
    function setting_cast(?string $value, string $type): mixed
    {
        if ($value === null) {
            return null;
        }

        return match ($type) {
            'bool' => filter_var($value, FILTER_VALIDATE_BOOL),
            'int' => (int) $value,
            'float' => (float) $value,
            'json' => json_decode($value, true),
            default => $value,
        };
    }
}

if (! function_exists('setting')) {
    /**
     * Read a persisted application setting from the `settings` table.
     *
     *   setting()                 → all settings as [key => casted value]
     *   setting('site_name')      → casted value, or null if missing
     *   setting('per_page', 25)   → casted value, or 25 if missing
     *
     * Values are cast according to their stored `type` column
     * (bool / int / float / json / string). A per-request static cache keeps
     * this to a single query. Safe to call before the table exists (e.g.
     * during migrations) — it returns the default in that case.
     */
    function setting(?string $key = null, mixed $default = null): mixed
    {
        $cache = setting_cache();

        if ($cache === null) {
            try {
                $cache = Setting::query()
                    ->get(['key', 'value', 'type'])
                    ->mapWithKeys(fn ($row) => [
                        $row->key => setting_cast($row->value, $row->type),
                    ])
                    ->all();
            } catch (Throwable $e) {
                // Table may not exist yet (fresh install / mid-migration).
                return $key === null ? [] : $default;
            }

            setting_cache($cache);
        }

        if ($key === null) {
            return $cache;
        }

        return array_key_exists($key, $cache) ? $cache[$key] : $default;
    }
}

if (! function_exists('setting_set')) {
    /**
     * Create or update a persisted setting and clear the in-request cache.
     *
     * The value is normalised for storage based on $type (json values are
     * encoded, booleans stored as '1'/'0'). Subsequent setting() calls in the
     * same request re-read from the database.
     */
    function setting_set(string $key, mixed $value, string $type = 'string'): void
    {
        $stored = match ($type) {
            'json' => json_encode($value),
            'bool' => $value ? '1' : '0',
            default => $value === null ? null : (string) $value,
        };

        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $stored, 'type' => $type],
        );

        // Invalidate the per-request static cache held by setting().
        setting_cache(flush: true);
    }
}
