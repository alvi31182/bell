<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Entity\Security\Token;
use App\Entity\Security\User;
use App\Repository\Security\TokenReadStorage;
use App\Repository\Security\TokenWriteStorage;
use Doctrine\ORM\EntityManager;

final class ApiTokenService
{
    /*private TokenReadStorage $tokeReadStorage;
    private TokenWriteStorage $tokenWriteStorage;
    private EntityManager $em;

    public function __construct(TokenReadStorage $tokenReadStorage, TokenWriteStorage $tokenWriteStorage)
    {
        $this->tokeReadStorage = $tokenReadStorage;
        $this->tokenWriteStorage = $tokenWriteStorage;
    }

    public function getApiToken($token)
    {
        $this->tokeReadStorage->findById($token);
    }

    public function findByToken($token): ?Token
    {
        return $this->tokeReadStorage->findByToken($token);
    }

    public function createToken(User $user, \DateInterval $dateInterval): string
    {
        $token =  new Token(
            $user,
            $dateInterval
        );

        $this->tokenWriteStorage->update($token);

        return $token->getToken();
    }*/
}