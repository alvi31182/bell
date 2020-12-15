<?php

declare(strict_types=1);

namespace App\Repository\Security;



use App\Entity\Security\Token;

interface TokenWriteStorage
{
    public function add(Token $token): void;
    public function update(Token $token): void;
}