<?php

declare(strict_types=1);

namespace App\Media\Storage;

use App\Media\Storage\S3\UploadException;

interface Storage
{
    /**
     * @throws UploadException
     */
    public function generateUploadLink(string $fileName): UploadLink;
}
