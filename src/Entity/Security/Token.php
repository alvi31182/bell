<?php

declare(strict_types=1);

namespace App\Entity\Security;

use App\Exceptions\AuthorException\TokenExpired;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use App\Repository\Security\ApiTokenRepository;

/**
 * @ORM\Entity(repositoryClass=ApiTokenRepository::class)
 */
final class Token
{
    const SIGNATURE_LENGTH = 32;
    /**
     * @var UuidInterface
     * @ORM\Column(name="id", type="uuid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private UuidInterface $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $token;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetimetz_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetimetz_immutable")
     */
    private \DateTimeImmutable $expiredAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Security\User", cascade={"persist"}, inversedBy="apiToken")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @param User $user
     * @param \DateInterval $tokenTtl
     * @throws \Exception
     */
    public function __construct(User $user, \DateInterval $tokenTtl)
    {
        $this->id = Uuid::uuid4();
        $this->token = base64_encode(bin2hex(random_bytes(60)));
        $this->createdAt = new \DateTimeImmutable();
        $this->expiredAt = (new \DateTimeImmutable())->add($tokenTtl);
        $this->user = $user;
    }

    public function renewal(\DateInterval $tokenTtl): void
    {
        $this->expiredAt = (new \DateTimeImmutable())->add($tokenTtl);
    }

    public function markAsExpired(): void
    {
        $this->expiredAt = new \DateTimeImmutable('-1second');
    }

    public function isAlive(): bool
    {
        return $this->expiredAt > new \DateTimeImmutable();
    }

    /**
     * @throws TokenExpired
     */
    public function authorize(): void
    {
        if(!$this->isAlive()) {
            throw new TokenExpired(sprintf('Token expired %s', $this->getId()->toString()));
        }
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getExpiresAt(): \DateTimeImmutable
    {
        return $this->expiredAt;
    }

    public function getUser(): User
    {
        return $this->user;
    }

}