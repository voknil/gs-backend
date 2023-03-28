<?php

namespace App\Entity;

use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
class Organization
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(length: 255, unique: true, nullable: false)]
    private string $name;

    #[ORM\Column(length: 255)]
    private ?string $address;

    #[ORM\Column(length: 255)]
    private ?string $type;

    #[ORM\Column(length: 255)]
    private ?string $website;

    #[ORM\Column(type: 'text', unique: false, nullable: true)]
    private ?string $description;

    #[ORM\Column(length: 255)]
    private ?string $vk;

    #[ORM\Column(length: 255)]
    private ?string $facebook;

    #[ORM\Column(length: 255)]
    private ?string $instagram;

    #[ORM\Column(length: 255)]
    private ?string $telegram;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'organizations')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public static function create(
        Uuid    $id,
        string  $name,
        ?string $address = null,
        ?string $type = null,
        ?string $website = null,
        ?string $description = null,
        ?string $vk = null,
        ?string $facebook = null,
        ?string $instagram = null,
        ?string $telegram = null,
    ): static
    {
        $organization = new static();
        $organization->id = $id;
        $organization->address = $address;
        $organization->name = $name;
        $organization->type = $type;
        $organization->website = $website;
        $organization->description = $description;
        $organization->vk = $vk;
        $organization->facebook = $facebook;
        $organization->instagram = $instagram;
        $organization->telegram = $telegram;

        return $organization;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addOrganization($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeOrganization($this);
        }

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function getVk(): ?string
    {
        return $this->vk;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function getTelegram(): ?string
    {
        return $this->telegram;
    }
}
