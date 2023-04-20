<?php

namespace App\Request\Organization\PhotoGallery;

use App\Request\JsonValidatedRequest;
use Symfony\Component\Uid\Uuid;

class OrganizationPhoto
{
    private Uuid $id;
    private string $mimeType;

    public function __construct($item)
    {
        $this->id=Uuid::fromString($item->id);
        $this->mimeType=$item->mimeType;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }
}
