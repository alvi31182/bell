<?php


namespace App\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticatorManagerInterface;

final class AuthenticatorListener
{
    private TokenStorageInterface $tokenStorage;
    private AuthenticatorManagerInterface $authenticationManager;
    private $providerKey = 'dddddd';

    public function __invoke(Request $event)
    {
        $request = $event->getContent();
        dd($request);
        $username = $request->getUser();
        dd($username);
        $password = $request->getPassword();

        $unauthenticatedToken = new UsernamePasswordToken(
            $username,
            $password,
            $this->providerKey
        );

        dd($unauthenticatedToken->getUser());

        $authenticatedToken = $this
            ->authenticationManager
            ->authenticate($unauthenticatedToken);

        $this->tokenStorage->setToken($authenticatedToken);
    }
}