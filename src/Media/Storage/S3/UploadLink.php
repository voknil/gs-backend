<?php

declare(strict_types=1);

namespace App\Media\Storage\S3;

use Symfony\Component\Uid\Uuid;

final class UploadLink implements \App\Media\Storage\UploadLink
{
    public function __construct(
        private readonly Uuid   $uuid,
        private readonly string $url,
        private readonly string $contentType,
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

    public function getContentType(): string
    {
        return $this->contentType;
    }
}
