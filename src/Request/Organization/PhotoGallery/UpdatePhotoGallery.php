<?php

namespace App\Request\Organization\PhotoGallery;

use App\Request\JsonValidatedRequest;

class UpdatePhotoGallery extends JsonValidatedRequest
{
    protected array $media;

    private function getMediaArray(): array
    {
        return $this->media;
    }


    /**
     * @return OrganizationPhoto[]
     */
    public function getMedia(): array
    {
        return array_map(function ($item) {
            return new OrganizationPhoto($item);
        }, $this->getMediaArray());
    }

}
