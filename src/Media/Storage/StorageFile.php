<?php

declare(strict_types=1);

namespace App\Media\Storage;

use Symfony\Component\Uid\Uuid;

final class StorageFile
{
    public function __construct(
        private readonly Uuid    $id,
        private readonly string  $url,
        private readonly ?string $size,
        private readonly ?string $type,
        private readonly ?string $name = null
    )
    {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
