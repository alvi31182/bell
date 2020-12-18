<?php

declare(strict_types=1);

namespace App\Security;

use App\Security\Interfaces\AuthFailureResponseBuilder;
use App\Service\Security\ApiTokenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{

    private EntityManagerInterface $em;
    private ApiTokenService $tokenService;
    private AuthFailureResponseBuilder $responseBuilder;

    public function __construct(EntityManagerInterface $em, ApiTokenService $apiTokenService, AuthFailureResponseBuilder $responseBuilder)
    {
        $this->em = $em;
        $this->tokenService = $apiTokenService;
        $this->responseBuilder = $responseBuilder;
    }

    public function supports(Request $request): bool
    {
        return $request->headers->has('Authorization')
            && 0 === strpos($request->headers->get('Authorization'), 'Bearer ');
    }

    public function getCredentials(Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        // skip beyond "Bearer "
        return substr($authorizationHeader, 7);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {

        dd($credentials);
        $token = $this->tokenService->findByToken($credentials);

        if (!$token) {
            throw new CustomUserMessageAuthenticationException(
                'Invalid API Token'
            );
        }

        if(!$token->isAlive()){
            throw new CustomUserMessageAuthenticationException(
                'Token expired'
            );
        }

        return $token->getToken();
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        dd('checking credentials');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(
            [
                'message' => $exception->getMessageKey()
            ], 401
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        return;
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return $this->responseBuilder->unauthorized($authException);
    }

}