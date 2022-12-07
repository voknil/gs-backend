<?php

declare(strict_types=1);

namespace App\Media\Storage\S3;

use Aws\Exception\MultipartUploadException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\MultipartUploader;
use Aws\S3\ObjectUploader;
use Aws\S3\S3ClientInterface;
use Psr\Log\LoggerInterface;

final class Bucket
{
    public function __construct(
        private readonly S3ClientInterface $s3Client,
        private readonly LoggerInterface   $logger,
        private readonly string            $s3BucketName,
        private readonly string            $s3BucketTtl,
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
        $request = $this->s3Client->createPresignedRequest($command, $this->$s3BucketTtl);

        return (string)$request->getUri();
    }

    public function getUploadPreSignedUrl(string $key): string
    {
        $command = $this->s3Client->getCommand('PutObject', ['Bucket' => $this->s3BucketName, 'Key' => $key]);
        $request = $this->s3Client->createPresignedRequest($command, $this->s3BucketTtl);

        return (string)$request->getUri();
    }
}
