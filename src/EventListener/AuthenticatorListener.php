<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Service\Security\ApiTokenService;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class AuthenticatorListener
{
    private TokenStorageInterface $tokenStorage;
    private ApiTokenService $tokenService;

    public function __construct(TokenStorageInterface $tokenStorage, ApiTokenService $tokenService)
    {
        $this->tokenStorage = $tokenStorage;
        $this->tokenService = $tokenService;
    }


}