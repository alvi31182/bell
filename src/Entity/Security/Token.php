<?php

declare(strict_types=1);

namespace App\Entity\Security;

use App\Event\Security\DeviceEvent;
use App\Exceptions\AuthorException\TokenExpired;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use App\Repository\Security\ApiTokenRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * @ORM\Entity(repositoryClass=ApiTokenRepository::class)
 */
 class Token
{
    const SIGNATURE_LENGTH = 52;
    /**
     * @var UuidInterface
     *
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
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Device", mappedBy="token", cascade={"persist"})
     */
    private Collection $device;

    /**
     * @var \DateTimeImmutable
     *
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
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetimetz_immutable", nullable=true)
     */
    private \DateTimeImmutable $updatedAt;

     /**
      * @param string $token
      * @param \DateInterval $tokenTtl
      */
    public function __construct(string $token, \DateInterval $tokenTtl)
    {
        $this->id = Uuid::uuid4();
        $this->token = $token;
        $this->createdAt = new \DateTimeImmutable();
        $this->expiredAt = (new \DateTimeImmutable())->add($tokenTtl);
        $this->device = new ArrayCollection();
    }

     public function updateToken(string $token, \DateInterval $dateInterval): void
     {
         $this->token = $token;
         $this->updatedAt = new \DateTimeImmutable();
         $this->renewal($dateInterval);
     }

    public function renewal(\DateInterval $tokenTtl): void
    {
        $this->expiredAt = (new \DateTimeImmutable())->add($tokenTtl);
    }

    public function markAsExpired(): void
    {
        $this->expiredAt = new \DateTimeImmutable();
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

    public function createDevice(User $user, string $hardwireId): void
    {

        $device = new Device(
            Uuid::uuid4(),
            $user,
            $this,
            $hardwireId,
            'dd'
        );

        $this->device->add($device);
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

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDevice(): Collection
    {
        return $this->device;
    }

}