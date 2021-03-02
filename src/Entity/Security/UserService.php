<?php

declare(strict_types=1);

namespace App\Entity\Security;

use App\Data\User\UserRegistrationData;
use App\Repository\Security\User\UserReadStorage;
use App\Service\Security\Interfaces\UserRegistrationInterface;

final class UserService implements UserRegistrationInterface
{
    private UserReadStorage $readStorage;

    public function __construct(UserReadStorage $readStorage)
    {
        $this->readStorage = $readStorage;
    }

    public function register(UserRegistrationData $data): void
    {
        $user = $this->readStorage->findByEmail($data->getEmail());
        dd($user);
    }
}