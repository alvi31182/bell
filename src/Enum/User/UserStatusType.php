<?php

declare(strict_types=1);

namespace App\Enum\User;

use App\Entity\Security\UserStatus;
use App\Enum\DoctrineType\EnumerableType;

final class UserStatusType extends EnumerableType
{

    protected function getEnumClass(): string
    {
        return UserStatus::class;
    }

    public function getName(): string
    {
        return 'user_status';
    }
}