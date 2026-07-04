<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\FileUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

/**
 * A stored file, optionally attached to any model via a polymorphic relation.
 *
 * Files are persisted on a Laravel filesystem disk; this row keeps the
 * metadata (path, mime, size, collection) so uploads can be listed, served
 * and cleaned up without touching the disk.
 */
class MediaFile extends Model
{
    /**
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'size' => 'integer',
            'meta' => 'array',
        ];
    }

    /**
     * The owning model this file is attached to, if any.
     *
     * @return MorphTo<Model, $this>
     */
    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Public URL for the stored file on its disk.
     */
    public function getUrlAttribute(): ?string
    {
        try {
            return Storage::disk($this->disk)->url($this->path);
        } catch (\Throwable) {
            // Private disks (e.g. local) do not expose a URL — that's fine.
            return null;
        }
    }

    /**
     * Whether the file is an image based on its stored MIME type.
     */
    public function isImage(): bool
    {
        return $this->mime !== null && str_starts_with($this->mime, 'image/');
    }

    /**
     * Human-readable size: "1,5 MB".
     */
    public function getHumanSizeAttribute(): string
    {
        return FileUploadHelper::humanSize((int) $this->size);
    }
}
