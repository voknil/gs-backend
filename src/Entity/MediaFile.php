<?php

namespace App\Entity;

use App\Repository\MediaFileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
#[ORM\Entity(repositoryClass: MediaFileRepository::class)]
#[ORM\Table(name: "media_file")]
class MediaFile
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(length: 180, nullable: true)]
    private string $title;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTimeInterface $updatedAt;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $mimeType;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $size;

    public static function create(
        string $title,
        string $mimeType,
        int $size
    ): static
    {
        $mediaFile = new static();

        $mediaFile->id = Uuid::v4();
        $mediaFile->title = $title;
        $mediaFile->createdAt = new \DateTimeImmutable();
        $mediaFile->updatedAt = new \DateTimeImmutable();
        $mediaFile->mimeType = $mimeType;
        $mediaFile->size = $size;

        return $mediaFile;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

}
