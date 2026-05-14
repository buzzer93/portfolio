<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    public function upload(UploadedFile $file, string $targetDirectory): string
    {
        $this->ensureWritableDirectory($targetDirectory);

        $filename = uniqid() . '.' . $file->guessExtension();
        $file->move($targetDirectory, $filename);

        return $filename;
    }

    public function remove(string $targetDirectory, string $filename): void
    {
        $targetDirectory = rtrim($targetDirectory, '/\\');

        // Some legacy rows may store a prefixed path (e.g. files/cv.pdf).
        // We normalize to a plain filename to always target the expected directory.
        $normalizedFilename = basename(str_replace('\\', '/', $filename));
        $path = $targetDirectory . '/' . $normalizedFilename;

        if (is_file($path)) {
            unlink($path);
        }
    }

    private function ensureWritableDirectory(string $targetDirectory): void
    {
        $normalizedDirectory = rtrim($targetDirectory, '/\\');

        if ($normalizedDirectory === '') {
            throw new FileException('Le répertoire cible de téléversement est invalide.');
        }

        if (!is_dir($normalizedDirectory) && !@mkdir($normalizedDirectory, 0775, true) && !is_dir($normalizedDirectory)) {
            throw new FileException(sprintf('Impossible de créer le répertoire de téléversement "%s".', $normalizedDirectory));
        }

        if (!is_writable($normalizedDirectory)) {
            throw new FileException(sprintf('Le répertoire de téléversement "%s" n\'est pas accessible en écriture.', $normalizedDirectory));
        }
    }
}
