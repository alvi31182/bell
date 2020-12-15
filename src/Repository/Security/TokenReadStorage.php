<?php

namespace App\Repository\Security;

use App\Entity\Security\Token;
use Ramsey\Uuid\UuidInterface;

interface TokenReadStorage
{
    public function findById(UuidInterface $id): ?Token;
    public function getAndLock(UuidInterface $id): ?Token;
    public function findByToken(string $credentials): ?Token;
}