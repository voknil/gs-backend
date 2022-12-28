<?php

declare(strict_types=1);

namespace App\Media\Storage\S3;

use App\Media\Storage\StorageFile;
use Aws\S3\Exception\S3Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;

final class Storage implements \App\Media\Storage\Storage
{
    public function __construct(
        private readonly Bucket          $bucket,
        private readonly LoggerInterface $logger,
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

    public function getFileByUuid(Uuid $uuid): ?StorageFile
    {
        try {
            return $this->bucket->getStorageFile($uuid);
        } catch (S3Exception $exception) {
            $this->logger->error(
                sprintf('Cannot retrieve file by uuid %s due to %s', $uuid, $exception->getMessage())
            );
            return null;
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
