<?php

declare(strict_types=1);

namespace App\Media\Storage;

use App\Exception\MediaException;
use App\Media\Storage\S3\UploadException;

final class UploadLinkGenerator
{
    public function __construct(
        private readonly Storage $storage,
    )
    {
    }

    /**
     * @throws MediaException
     */
    public function generate(GenerateUploadLink $command): UploadLink
    {
        try {
            return $this->storage->generateUploadLink($command->getFileName());
        } catch (UploadException $exception) {
            throw new MediaException(message: 'Unable to generate upload link', previous: $exception->getPrevious());
        }
    }
}
