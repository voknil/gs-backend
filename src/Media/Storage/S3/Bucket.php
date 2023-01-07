<?php

declare(strict_types=1);

namespace App\Media\Storage\S3;

use App\Media\Storage\StorageFile;
use Aws\Exception\MultipartUploadException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\MultipartUploader;
use Aws\S3\ObjectUploader;
use Aws\S3\S3Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;

final class Bucket
{
    private const TYPE_EXTENSION_MAP = [
        'text/csv' => 'csv',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'image/jpeg' => 'jpeg',
        'image/png' => 'png',
        'application/pdf' => 'pdf',
        'application/rtf' => 'rtf',
        'image/tiff' => 'tiff',
        'application/vnd.ms-excel' => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
    ];

    public function __construct(
        private readonly S3Client        $s3Client,
        private readonly LoggerInterface $logger,
        private readonly string          $s3BucketName,
        private readonly string          $s3BucketTtl,
    )
    {
    }

    /**
     * @throws UploadException
     */
    public function put(string $key, mixed $body): void
    {
        try {
            $this->s3Client->putObject(
                [
                    'Key' => $key,
                    'Body' => $body,
                    'ContentMD5' => base64_encode(md5($body, true)),
                ]
            );
        } catch (S3Exception $e) {
            $this->logger->warning(sprintf('Unable to upload file to S3 bucket with key "%s"', $key), ['message' => $e->getMessage()]);
            throw new UploadException(message: 'Unable to upload file to S3 bucket', previous: $e);
        }
    }

    /**
     * @throws UploadException
     */
    public function putFromPath(string $key, string $path): void
    {
        $stream = fopen($path, 'rb');
        if (false === $stream) {
            throw new UploadException(message: sprintf("File from path %s does not exist", $path));
        }

        $uploader = new ObjectUploader($this->s3Client, $this->s3BucketName, $key, $stream);

        do {
            try {
                $result = $uploader->upload();
            } catch (MultipartUploadException $e) {
                rewind($stream);
                $uploader = new MultipartUploader($this->s3Client, $stream, [
                    'state' => $e->getState(),
                ]);
            }
        } while (!isset($result));
    }

    /**
     * @param array<string, mixed> $options
     * @throws S3Exception
     */
    public function getStorageFile(Uuid $uuid, ?string $name = null, array $options = []): ?StorageFile
    {
        $key = $this->findObjectKeyByName($uuid);
        if (null === $key) {
            $this->logger->warning(sprintf('Unable to find file to S3 bucket by key "%s"', $uuid));
            return null;
        }

        $data = $this->s3Client->headObject([
            'Bucket' => $this->s3BucketName,
            'Key' => $key,
        ]);

        /** @var string|null $contentType */
        $contentType = $data->get('ContentType');

        $extension = $this->getExtensionByKeyOrContentType($key, $contentType);

        $fileName = $name ?? (string)$uuid;
        if (null !== $extension) {
            $fileName .= '.' . $extension;
        }

        if (null !== $name) {
            $options = array_merge($options, ['ResponseContentDisposition' => 'attachment; filename="' . $fileName . '"']);
        }

        /** @var array<string, mixed>|null $metadata */
        $metadata = $data->get('@metadata');

        return
            new StorageFile(
                $uuid,
                $this->getPresignedUrl($key, $options),
                $metadata['headers']['content-length'] ?? null,
                $contentType,
                $fileName
            );
    }

    public function getPreSignedUrl(string $key, array $options = []): string
    {
        $command =
            $this->s3Client->getCommand(
                'GetObject',
                array_merge(
                    $options,
                    [
                        'Bucket' => $this->s3BucketName,
                        'Key' => $key,
                    ]
                )
            );
        $request = $this->s3Client->createPresignedRequest($command, $this->s3BucketTtl);

        return (string)$request->getUri();
    }

    public function getUploadPreSignedUrl(string $key): string
    {
        $command = $this->s3Client->getCommand('PutObject', ['Bucket' => $this->s3BucketName, 'Key' => $key]);
        $request = $this->s3Client->createPresignedRequest($command, $this->s3BucketTtl);

        return (string)$request->getUri();
    }

    public function getContentTypeByKey(string $key): ?string
    {
        return $this->getContentTypeByExtension($this->getExtensionByKey($key));
    }

    private function findObjectKeyByName(string|Uuid $name): ?string
    {
        return $this->findObjectKeysByName($name, 1)[0] ?? null;
    }

    private function findObjectKeysByName(string|Uuid $name, int $limit = 100): array
    {
        /** @var array|null $objects */
        $objects = $this->s3Client->execute(
            $this->s3Client->getCommand(
                'ListObjects',
                [
                    'Bucket' => $this->s3BucketName,
                    'Prefix' => (string)$name,
                    'MaxKeys' => $limit,
                ]
            )
        );

        return $objects['Contents'] ? array_map(static fn(array $object) => $object['Key'], $objects['Contents']) : [];
    }

    private function getExtensionByKeyOrContentType(string $key, ?string $contentType): ?string
    {
        $extension = $this->getExtensionByKey($key);
        if (null !== $extension) {
            return $extension;
        }

        if (null === $contentType) {
            return null;
        }

        return $this->getExtensionByContentType($contentType);
    }

    private function getExtensionByKey(string $key): ?string
    {
        return pathinfo($key)['extension'] ?? null;
    }

    private function getExtensionByContentType(string $contentType): ?string
    {
        return self::TYPE_EXTENSION_MAP[$contentType] ?? null;
    }

    private function getContentTypeByExtension(string $extension): ?string
    {
        return array_flip(self::TYPE_EXTENSION_MAP)[$extension] ?? null;
    }
}
