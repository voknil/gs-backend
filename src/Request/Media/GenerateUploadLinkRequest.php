<?php

declare(strict_types=1);

namespace App\Request\Media;

use App\Media\Storage\GenerateUploadLink;
use App\Request\JsonValidatedRequest;
use Symfony\Component\Validator\Constraints as Assert;

final class GenerateUploadLinkRequest extends JsonValidatedRequest implements GenerateUploadLink
{
    #[Assert\NotBlank]
    protected ?string $fileName;

    public function getFileName(): string
    {
        return $this->fileName;
    }

}
