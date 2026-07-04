<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

/**
 * Central service for recording activity log entries.
 *
 * Captures the acting user and request IP automatically and resolves the
 * subject (morph) type/id from an optional Eloquent model.
 */
final class ActivityLogger
{
    /**
     * Record an activity log entry.
     *
     * @param  array<string, mixed>  $properties
     */
    public function log(string $event, string $description, ?Model $subject = null, array $properties = []): ActivityLog
    {
        return ActivityLog::create([
            'user_id' => auth()->id(),
            'event' => $event,
            'description' => $description,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'properties' => $properties ?: null,
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Record a "created" event for the given subject.
     *
     * @param  array<string, mixed>  $properties
     */
    public static function created(Model $subject, string $description, array $properties = []): ActivityLog
    {
        return (new self)->log('created', $description, $subject, $properties);
    }

    /**
     * Record an "updated" event for the given subject.
     *
     * @param  array<string, mixed>  $properties
     */
    public static function updated(Model $subject, string $description, array $properties = []): ActivityLog
    {
        return (new self)->log('updated', $description, $subject, $properties);
    }

    /**
     * Record a "deleted" event for the given subject.
     *
     * @param  array<string, mixed>  $properties
     */
    public static function deleted(Model $subject, string $description, array $properties = []): ActivityLog
    {
        return (new self)->log('deleted', $description, $subject, $properties);
    }

    /**
     * Record an authentication-related event (login, logout, etc.).
     *
     * @param  array<string, mixed>  $properties
     */
    public static function auth(string $event, string $description, array $properties = []): ActivityLog
    {
        return (new self)->log($event, $description, null, $properties);
    }
}
