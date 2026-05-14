<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\FileUploader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class FileUploaderTest extends TestCase
{
    private string $workspace;

    protected function setUp(): void
    {
        $this->workspace = sys_get_temp_dir() . '/portfolio-file-uploader-' . bin2hex(random_bytes(8));
    }

    protected function tearDown(): void
    {
        if (!is_dir($this->workspace)) {
            return;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->workspace, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST,
        );

        foreach ($iterator as $item) {
            if ($item->isDir()) {
                rmdir($item->getPathname());

                continue;
            }

            unlink($item->getPathname());
        }

        rmdir($this->workspace);
    }

    public function testUploadCreatesTargetDirectoryWhenMissing(): void
    {
        mkdir($this->workspace, 0775, true);
        $sourceFile = $this->workspace . '/source.txt';
        file_put_contents($sourceFile, 'portfolio');

        $uploadedFile = new UploadedFile($sourceFile, 'source.txt', 'text/plain', null, true);
        $targetDirectory = $this->workspace . '/nested/uploads/images';

        $filename = (new FileUploader())->upload($uploadedFile, $targetDirectory);

        self::assertDirectoryExists($targetDirectory);
        self::assertFileExists($targetDirectory . '/' . $filename);
    }
}