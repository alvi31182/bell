<?php

declare(strict_types=1);

namespace App\Service\Security\Interfaces;

use App\Data\User\UserRegistrationData;

interface UserRegistrationInterface
{
    public function register(UserRegistrationData $data): void;
}