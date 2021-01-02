<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;

final class RequestTransformerListener implements AuthenticationManagerInterface, UserAuthenticatorInterface
{
    public function __invoke(RequestEvent $event){
        $request = $event->getRequest();
        $event = $request->getContent();
    }

    public function authenticate(TokenInterface $token)
    {
        dd($token);
    }

    public function authenticateUser(
        UserInterface $user,
        AuthenticatorInterface $authenticator,
        Request $request
    ): ?Response {
        dd($user->getPassword());
    }
}