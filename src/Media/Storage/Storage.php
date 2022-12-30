<?php

declare(strict_types=1);

namespace App\Media\Storage;

use App\Media\Storage\S3\UploadException;
use Symfony\Component\Uid\Uuid;

interface Storage
{
    /**
     * @throws UploadException
     */
    public function generateUploadLink(string $fileName): UploadLink;

    public function getFileByUuid(Uuid $uuid): ?StorageFile;
}
