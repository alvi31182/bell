<?php

declare(strict_types=1);

namespace App\Repository\Security\User;

use App\Entity\Security\User;
use Ramsey\Uuid\UuidInterface;

interface UserReadStorage
{
    public function findById(UuidInterface $id): ?User;
    public function findByEmail(string $email): ?User;
    public function checkUserPassword(string $password): User;
}