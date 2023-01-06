<?php

namespace App\Tests\Media\Storage;

use App\Exception\MediaException;
use App\Media\Storage\GenerateUploadLink;
use App\Media\Storage\S3\UploadException;
use App\Media\Storage\Storage;
use App\Media\Storage\UploadLink;
use App\Media\Storage\UploadLinkGenerator;
use PHPUnit\Framework\TestCase;

class UploadLinkGeneratorTest extends TestCase
{
    public function testGenerateSuccess(): void
    {
        $storage = $this->createMock(Storage::class);
        $storage->expects($this->once())
            ->method('generateUploadLink')
            ->willReturn($this->createMock(UploadLink::class));

        $uploadLinkGenerator = new UploadLinkGenerator($storage);

        $command = $this->createStub(GenerateUploadLink::class);

        $uploadLinkGenerator->generate($command);
    }

    public function testGenerateFail(): void
    {
        $storage = $this->createMock(Storage::class);
        $storage->expects($this->once())
            ->method('generateUploadLink')
            ->willThrowException(new UploadException());

        $uploadLinkGenerator = new UploadLinkGenerator($storage);

        $command = $this->createStub(GenerateUploadLink::class);

        $this->expectException(MediaException::class);
        $uploadLinkGenerator->generate($command);
    }
}
