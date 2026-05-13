<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    public function upload(UploadedFile $file, string $targetDirectory): string
    {
        $filename = uniqid() . '.' . $file->guessExtension();
        $file->move($targetDirectory, $filename);

        return $filename;
    }

    public function remove(string $targetDirectory, string $filename): void
    {
        $targetDirectory = rtrim($targetDirectory, '/');

        // Some legacy rows may store a prefixed path (e.g. files/cv.pdf).
        // We normalize to a plain filename to always target the expected directory.
        $normalizedFilename = basename(str_replace('\\', '/', $filename));
        $path = $targetDirectory . '/' . $normalizedFilename;

        if (is_file($path)) {
            unlink($path);
        }
    }
}
