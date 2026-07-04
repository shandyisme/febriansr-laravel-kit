<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MediaFile;
use App\Support\FileUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

/**
 * Store, replace and delete {@see MediaFile} records together with their
 * underlying files on disk. Keeps controllers thin (see AGENTS.md →
 * "Controller tetap tipis").
 */
final class MediaService
{
    /**
     * Store an uploaded file and record it, optionally attaching it to a model.
     *
     * @param  UploadedFile  $file  The validated uploaded file.
     * @param  Model|null  $mediable  Owner model to attach the file to.
     * @param  string  $collection  Logical grouping (e.g. "avatar", "gallery").
     * @param  string  $disk  Filesystem disk to store on.
     */
    public function upload(
        UploadedFile $file,
        ?Model $mediable = null,
        string $collection = 'default',
        string $disk = 'local',
    ): MediaFile {
        $stored = FileUploadHelper::store($file, $collection, $disk);

        return MediaFile::create([
            'mediable_type' => $mediable?->getMorphClass(),
            'mediable_id' => $mediable?->getKey(),
            'disk' => $disk,
            'path' => $stored['path'],
            'name' => $stored['original_name'],
            'mime' => $stored['mime'],
            'size' => $stored['size'],
            'collection' => $collection,
            'meta' => [
                'extension' => $stored['extension'],
                'stored_name' => $stored['name'],
            ],
        ]);
    }

    /**
     * Replace the file behind an existing record: the old file is removed from
     * disk, the new one stored, and the row updated in place.
     */
    public function replace(MediaFile $media, UploadedFile $file): MediaFile
    {
        FileUploadHelper::delete($media->path, $media->disk);

        $stored = FileUploadHelper::store($file, $media->collection ?? 'default', $media->disk);

        $media->fill([
            'path' => $stored['path'],
            'name' => $stored['original_name'],
            'mime' => $stored['mime'],
            'size' => $stored['size'],
            'meta' => array_merge($media->meta ?? [], [
                'extension' => $stored['extension'],
                'stored_name' => $stored['name'],
            ]),
        ]);
        $media->save();

        return $media;
    }

    /**
     * Remove a record together with its file on disk.
     */
    public function delete(MediaFile $media): void
    {
        FileUploadHelper::delete($media->path, $media->disk);

        $media->delete();
    }
}
