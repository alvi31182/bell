<?php

declare(strict_types=1);

namespace App\Data\User;

use Ramsey\Uuid\UuidInterface;

final class UserData
{
    private UuidInterface $id;
    private UuidInterface $tokenId;
    private array $roles;

    public function __construct(UuidInterface $id, UuidInterface $tokenId, array $roles)
    {
        $this->id = $id;
        $this->tokenId = $tokenId;
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

    public function getRoles(): array
    {
        return $this->roles;
    }
}