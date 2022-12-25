<?php

declare(strict_types=1);

namespace App\Media\Storage\S3;

use Symfony\Component\Uid\Uuid;

final class Storage implements \App\Media\Storage\Storage
{
    public function __construct(
        private readonly Bucket $bucket,
    )
    {
    }

    /**
     * @throws UploadException
     */
    public function generateUploadLink(string $fileName): \App\Media\Storage\UploadLink
    {
        $uuid = Uuid::v4();
        $key = $this->generateFileNameWithExtension(
            $uuid,
            $fileName
        );

        try {
            return new UploadLink($uuid, $this->bucket->getUploadPreSignedUrl($key));
        } catch (\Throwable $exception) {
            throw new UploadException(previous: $exception);
        }

    }

    private function generateFileNameWithExtension(Uuid $uuid, string $fileName): string
    {
        $fileInfo = pathinfo($fileName);
        $extension = $fileInfo['extension'] ?? '';

        if ($extension === '') {
            return (string)$uuid;
        }
        return sprintf('%s.%s', $uuid, $extension);
    }
}
