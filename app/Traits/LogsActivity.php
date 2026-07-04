<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\ActivityLog;
use App\Services\ActivityLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Automatically records activity log entries for a model's lifecycle events.
 *
 * Apply to any Eloquent model to log created/updated/deleted events. The
 * ActivityLog model itself is guarded to avoid infinite recursion.
 */
trait LogsActivity
{
    /**
     * Boot the trait and register the model event hooks.
     */
    public static function bootLogsActivity(): void
    {
        // Never log the ActivityLog model, otherwise every write loops forever.
        if (is_a(static::class, ActivityLog::class, true)) {
            return;
        }

        static::created(function (Model $model): void {
            static::recordActivity($model, 'created');
        });

        static::updated(function (Model $model): void {
            static::recordActivity($model, 'updated');
        });

        static::deleted(function (Model $model): void {
            static::recordActivity($model, 'deleted');
        });
    }

    /**
     * Record a single activity entry for the given model event.
     */
    protected static function recordActivity(Model $model, string $event): void
    {
        $name = Str::of(class_basename($model))->headline()->lower()->toString();

        (new ActivityLogger)->log(
            "{$name} {$event}",
            Str::ucfirst("{$name} {$event}"),
            $model,
        );
    }
}
