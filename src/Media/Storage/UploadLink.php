<?php

declare(strict_types=1);

namespace App\Media\Storage;


use Symfony\Component\Uid\Uuid;

interface UploadLink
{
    public function getUrl(): string;

    public function getUuid(): Uuid;

    public function getContentType(): ?string;
}
