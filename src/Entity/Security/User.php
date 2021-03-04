<?php

namespace App\Entity\Security;

use App\Entity\Security\ValueObjects\Email;
use App\Entity\Security\ValueObjects\Password;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(name="id", type="uuid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $lastName;

    /**
     * @ORM\Embedded(class="App\Entity\Security\ValueObjects\Email", columnPrefix=false)
     */
    private Email $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Device", mappedBy="user", cascade={"persist"})
     */
    private Collection $deviceList;

    /**
     * @ORM\Column(type="datetimetz_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetimetz_immutable", nullable=true)
     */
    private \DateTimeImmutable $updatedAt;

    /**
     * @ORM\Embedded(class="App\Entity\Security\ValueObjects\Password", columnPrefix=false)
     */
    private Password $password;

    /**
     * @ORM\Column(type="user_status")
     */
    private UserStatus $status;

    public function __construct(
        UuidInterface $id,
        Email $email,
        string $firstName,
        string $lastName,
        Password $password,
        UserStatus $status,
        array $roles
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->status = $status;
        $this->roles = $roles;
        $this->deviceList = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->firstName;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getStatus(): UserStatus
    {
        return $this->status;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDeviceList(): Collection
    {
        return $this->deviceList;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function isPasswordValid(string $password): bool
    {
        return password_verify($password, $this->password->getPassword());
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
