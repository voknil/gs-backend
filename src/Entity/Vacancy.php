<?php

namespace App\Entity;

use App\Repository\VacancyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: VacancyRepository::class)]
class Vacancy
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\ManyToOne(inversedBy: 'vacancies')]
    #[ORM\JoinColumn(nullable: false)]
    private VacancyCategory $category;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCategory(): ?VacancyCategory
    {
        return $this->category;
    }

    public function setCategory(?VacancyCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
