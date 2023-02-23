<?php

namespace App\Entity;

use App\Persistence\Repository\UserRepository;
use App\User\Command\UpdateUser;
use App\User\Enum\Gender;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(length: 180, unique: true, nullable: false)]
    private string $email;

    #[ORM\Column]
    private array $roles = [];


    #[ORM\ManyToMany(targetEntity: Organization::class, inversedBy: 'users')]
    private Collection $organizations;

    /**
     * @var string The hashed password
     */
    #[ORM\Column(nullable: false)]
    private string $password;

    #[ORM\Column(type: 'boolean', nullable: false)]
    private bool $isVerified = false;

    #[ORM\Column(type: 'string', length: 6, nullable: false)]
    private string $locale = 'ru';

    #[ORM\Column(type: 'string', length: '255', nullable: true)]
    private ?string $firstName;

    #[ORM\Column(type: 'string', length: '255', nullable: true)]
    private ?string $lastName;

    #[ORM\Column(type: 'gender', length: '32', nullable: true)]
    private ?Gender $gender;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private ?DateTimeImmutable $birthDate;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?Uuid $imageUuid;

    #[ORM\Column(type: 'string', length: '255', nullable: true)]
    private ?string $country;

    #[ORM\Column(type: 'string', length: '255', nullable: true)]
    private ?string $city;

    #[ORM\Column(type: 'string', length: '255',nullable: true)]
    private ?string $phone;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $aboutMe;

    #[ORM\Column(type: 'string', length: '255', nullable: true)]
    private ?string $vk;

    #[ORM\Column(type: 'string', length: '255', nullable: true)]
    private ?string $facebook;

    #[ORM\Column(type: 'string', length: '255', nullable: true)]
    private ?string $instagram;

    #[ORM\Column(type: 'string', length: '255', nullable: true)]
    private ?string $telegram;

    public static function create(Uuid $id, string $email): static
    {
        $user = new static();
        $user->id = $id;
        $user->email = $email;

        return $user;
    }

    public function update(UpdateUser $command): static
    {
        $this->firstName = $command->getFirstName();
        $this->lastName = $command->getLastName();
        $this->gender = $command->getGender();
        $this->birthDate = $command->getBirthDate();
        $this->imageUuid = $command->getImageUuid();
        $this->country = $command->getCountry();
        $this->city = $command->getCity();
        $this->setLocale($command->getLocale());
        $this->phone = $command->getPhone();
        $this->aboutMe = $command->getAboutMe();
        $this->vk = $command->getVk();
        $this->facebook = $command->getFacebook();
        $this->instagram = $command->getInstagram();
        $this->telegram = $command->getTelegram();

        return $this;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function getBirthDate(): ?DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function getImageUuid(): ?Uuid
    {
        return $this->imageUuid;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getAboutMe(): ?string
    {
        return $this->aboutMe;
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

    /**
     * @return Collection<int, Organization>
     */
    public function getOrganizations(): Collection
    {
        return $this->organizations;
    }

    public function addOrganization(Organization $organization): self
    {
        if (!$this->organizations->contains($organization)) {
            $this->organizations->add($organization);
        }

        return $this;
    }

    public function removeOrganization(Organization $organization): self
    {
        $this->organizations->removeElement($organization);

        return $this;
    }
}
