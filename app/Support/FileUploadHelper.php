<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Convenience wrapper around storing uploaded files.
 *
 * Centralises safe filename generation, metadata extraction and deletion so
 * controllers stay thin (see AGENTS.md → "Controller tetap tipis").
 */
final class FileUploadHelper
{
    /**
     * Store an uploaded file and return its metadata.
     *
     * @param  UploadedFile  $file  The validated uploaded file.
     * @param  string  $dir  Destination directory on the disk.
     * @param  string  $disk  Filesystem disk name.
     * @return array{path: string, name: string, original_name: string, mime: string, extension: string, size: int, human_size: string, disk: string, url: string|null}
     */
    public static function store(UploadedFile $file, string $dir = 'uploads', string $disk = 'local'): array
    {
        $name = self::safeName($file);
        $path = $file->storeAs($dir, $name, ['disk' => $disk]);

        $size = $file->getSize() ?: 0;

        return [
            'path' => $path,
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'extension' => strtolower($file->getClientOriginalExtension()),
            'size' => $size,
            'human_size' => self::humanSize($size),
            'disk' => $disk,
            'url' => self::urlFor($disk, $path),
        ];
    }

    /**
     * Generate a collision-resistant, filesystem-safe filename that preserves
     * the original extension.
     *
     *   "Foto Profil.PNG" → "foto-profil-9c2f1a0b8d.png"
     */
    public static function safeName(UploadedFile $file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $slug = Str::slug($base) ?: 'file';
        $unique = Str::lower(Str::random(10));

        return $extension !== ''
            ? "{$slug}-{$unique}.{$extension}"
            : "{$slug}-{$unique}";
    }

    /**
     * Delete a previously stored file. Returns true when the file was removed
     * (or already absent).
     */
    public static function delete(string $path, string $disk = 'local'): bool
    {
        if (! Storage::disk($disk)->exists($path)) {
            return true;
        }

        return Storage::disk($disk)->delete($path);
    }

    /**
     * Whether the uploaded file is an image based on its MIME type.
     */
    public static function isImage(UploadedFile $file): bool
    {
        return str_starts_with($file->getClientMimeType(), 'image/');
    }

    /**
     * Format a byte count into a human-readable size: "1.5 MB".
     */
    public static function humanSize(int $bytes): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $power = (int) min(floor(log($bytes, 1024)), count($units) - 1);
        $value = $bytes / (1024 ** $power);

        // Whole bytes never need decimals.
        $decimals = $power === 0 ? 0 : 1;

        return number_format($value, $decimals, ',', '.').' '.$units[$power];
    }

    /**
     * Resolve a public URL for a stored path when the disk supports it.
     */
    private static function urlFor(string $disk, string $path): ?string
    {
        try {
            return Storage::disk($disk)->url($path);
        } catch (\Throwable) {
            // Local (private) disks do not expose a URL — that's fine.
            return null;
        }
    }
}
