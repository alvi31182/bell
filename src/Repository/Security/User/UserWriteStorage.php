<?php

declare(strict_types=1);

namespace App\Repository\Security\User;

use App\Entity\Security\User;

interface UserWriteStorage
{
    public function add(User $user): void;
}