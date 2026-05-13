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
        $path = rtrim($targetDirectory, '/') . '/' . $filename;

        if (file_exists($path)) {
            unlink($path);
        }
    }
}
