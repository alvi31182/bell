<?php

declare(strict_types=1);

namespace App\Security;

use App\Data\User\UserData;
use App\Entity\Security\Device;
use App\Entity\Security\Token;
use App\Entity\Security\User;
use App\Exceptions\Security\TokenExtractionError;
use App\Repository\Security\DeviceRepository;
use App\Security\Interfaces\AuthFailureResponseBuilder;
use App\Security\Interfaces\TokenExtractor;
use App\Service\Security\ApiTokenService;
use App\Service\Security\AuthorizeService;
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
    private TokenExtractor $tokenExtractor;
    private AuthorizeService $authorizeService;

    public function __construct(
        EntityManagerInterface $em,
        ApiTokenService $apiTokenService,
        AuthFailureResponseBuilder $responseBuilder,
        TokenExtractor $tokenExtractor,
        AuthorizeService $authorizeService
    ) {
        $this->em = $em;
        $this->tokenService = $apiTokenService;
        $this->responseBuilder = $responseBuilder;
        $this->tokenExtractor = $tokenExtractor;
        $this->authorizeService = $authorizeService;
    }

    public function supports(Request $request): string
    {
        try {
            return $this->tokenExtractor($request);
        }catch (TokenExtractionError $extractionError){
            return $extractionError->getMessage();
        }
    }

    public function getCredentials(Request $request): Token
    {
        return $this->authorizeService->authorize($this->tokenExtractor($request));
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        $token = $this->tokenService->findByToken($credentials);

        $device = $this->em->getRepository(Device::class)->findOneBy(['id' => $token->getDevice()->first()]);
        $user = $this->em->getRepository(User::class)->findOneBy(['id' => $device->getUser()->getId()]);

        // dd($user->getEmail());
        if (!$token) {
            throw new CustomUserMessageAuthenticationException(
                'Invalid API Token'
            );
        }

        if (!$token->isAlive()) {
            throw new CustomUserMessageAuthenticationException(
                'Token expired'
            );
        }

        return $userProvider->loadUserByUsername($user->getEmail());
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
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

    public function getTokenExtractor(): TokenExtractor
    {
        return $this->tokenExtractor;
    }

    public function tokenExtractor(Request $request)
    {
        return $this->getTokenExtractor()->extract($request);
    }

}