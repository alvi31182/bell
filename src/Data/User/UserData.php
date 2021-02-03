<?php

declare(strict_types=1);

namespace App\Data\User;

use Ramsey\Uuid\UuidInterface;

final class UserData
{
    private UuidInterface $id;
    private UuidInterface $tokenId;
    private UuidInterface $deviceId;
    private string $username;
    private array $roles;

    public function __construct(UuidInterface $id, UuidInterface $tokenId, UuidInterface $deviceId, string $username, array $roles)
    {
        $this->id = $id;
        $this->tokenId = $tokenId;
        $this->deviceId = $deviceId;
        $this->username = $username;
        $this->roles = $roles;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getTokenId(): UuidInterface
    {
        return $this->tokenId;
    }

    public function getDeviceId(): UuidInterface
    {
        return $this->deviceId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}