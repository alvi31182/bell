<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Entity\Security\Token;
use App\Repository\Security\TokenReadStorage;

final class AuthorizeService
{
    private TokenReadStorage $tokenRadStorage;

    public function __construct(TokenReadStorage $tokenRadStorage)
    {
        $this->tokenRadStorage = $tokenRadStorage;
    }

    public function authorize(string $rawToken): Token
    {
        dd($rawToken);
        $token = $this->tokenRadStorage->findByToken($rawToken);
        dd($token);
    }
}