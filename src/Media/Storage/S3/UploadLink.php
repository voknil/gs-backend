<?php

declare(strict_types=1);

namespace App\Media\Storage\S3;

use App\Media\Storage\StorageType;
use Symfony\Component\Uid\Uuid;

final class UploadLink implements \App\Media\Storage\UploadLink
{
    public function __construct(
        private readonly Uuid   $uuid,
        private readonly string $url,
    )
    {
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getType(): StorageType
    {
        return StorageType::S3;
    }
}
