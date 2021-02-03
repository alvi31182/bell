<?php

declare(strict_types=1);

namespace App\Security;

use App\Data\User\UserData;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserProvider implements UserInterface
{
    private UserData $userData;

    public function __construct(UserData $userData)
    {
        $this->userData = $userData;
    }

    public function getRoles()
    {
        return $this->getUserData()->getRoles();
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername(): string
    {
        return $this->getUserData()->getId()->toString();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserData(): UserData
    {
        return $this->userData;
    }
}