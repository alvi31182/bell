<?php

declare(strict_types=1);

namespace App\Entity\Security;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Security\DeviceRepository;
use Ramsey\Uuid\UuidInterface;
use App\Entity\Security\User;

/**
 * @ORM\Entity(repositoryClass=DeviceRepository::class)
 */
class Device
{
    const
        DEFAULT_HARDWARE_ID = 'browser',
        DEFAULT_HARDWARE_NAME = 'Browser';

    /**
     * @var UuidInterface
     *
     * @ORM\Column(name="id", type="uuid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private UuidInterface $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="deviceList", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id")
     */
    private User $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false, options={"comment": "Device ID", "default": "browser"})
     */
    private string $hardwareId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false, options={"comment": "Device ID", "default": "Browser"})
     */
    private string $name;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default: false"})
     */
    private bool $isDeleted;

    /**
     * @var Token
     *
     * @ORM\ManyToOne(targetEntity="Token", inversedBy="device", cascade={"persist"})
     * @ORM\JoinColumn(name="token_id", referencedColumnName="id")
     */
    private Token $token;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetimetz_immutable", nullable=false)
     */
    private \DateTimeImmutable $createdAt;

    /**
     * Device constructor.
     * @param UuidInterface $id
     * @param User $user
     * @param Token $token
     * @param string $hardwareId
     * @param string $name
     */
    public function __construct(
        UuidInterface $id,
        User $user,
        Token $token,
        string $hardwareId,
        string $name
    ) {
        $this->id = $id;
        $this->user = $user;
        $this->hardwareId = $hardwareId;
        $this->name = $name;
        $this->isDeleted = false;
        $this->token = $token;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getHardwareId(): string
    {
        return $this->hardwareId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}