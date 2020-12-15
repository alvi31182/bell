<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Http\Authentication\AuthenticatorManagerInterface;

final class AuthenticatorListener
{
    private TokenStorage $tokenStorage;
    private AuthenticatorManagerInterface $authenticatorManager;
    private $providerKey;

    public function __invoke(RequestEvent $requestEvent){
        dd($requestEvent);
    }
}