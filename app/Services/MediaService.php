<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    /**
     * Store the uploaded file in the specified directory and return the path.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @return string
     */
    public function storeFile(UploadedFile $file, string $directory = 'uploads', string $disk = 'public'): string
    {
        return $file->store($directory, $disk);
    }

    /**
     * Delete the file from storage if it exists.
     *
     * @param string|null $path
     * @param string $disk
     * @return void
     */
    public function deleteFile(?string $path, string $disk = 'public'): void
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}
