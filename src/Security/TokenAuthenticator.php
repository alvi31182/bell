<?php

declare(strict_types=1);

namespace App\Security;

use App\Data\User\UserData;
use App\Entity\Security\Device;
use App\Entity\Security\Token;
use App\Entity\Security\User;
use App\Exceptions\AuthorException\TokenExpired;
use App\Exceptions\Security\TokenExtractionError;
use App\Repository\Security\DeviceRepository;
use App\Security\Interfaces\AuthFailureResponseBuilder;
use App\Security\Interfaces\TokenExtractor;
use App\Service\Security\ApiTokenService;
use App\Service\Security\AuthorizeService;
use App\Service\Security\Exception\LoginDisabled;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\InvalidArgumentException;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CredentialsExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\DisabledException;
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

    public function supports(Request $request)
    {
        /*return $request->headers->has('Authorization')
            && 0 === strpos($request->headers->get('Authorization'), 'Bearer ');*/
        try {
            $this->tokenExtractor($request);
            return true;
        } catch (TokenExtractionError $extractionError) {
            return $extractionError->getMessage();
        }
    }

    public function getCredentials(Request $request)
    {

        try {
            return $this->authorizeService->authorize($this->tokenExtractor($request));
        } catch (TokenExtractionError $tokenExtractionError) {
            throw new BadCredentialsException($tokenExtractionError->getMessage());
        } catch (LoginDisabled $loginDisabled) {
            throw new DisabledException($loginDisabled->getMessage());
        } catch (TokenExpired $tokenExpired) {
            throw new CredentialsExpiredException($tokenExpired->getMessage());
        }
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (!$credentials instanceof UserData) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The first argument of the "%s()" method must be an instance of "%s".',
                    __METHOD__,
                    UserData::class
                )
            );
        }

        if (!$userProvider instanceof EntityUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The second argument of the "%s()" method must be an instance of "%s", given %s',
                    __FUNCTION__,
                    EntityUserProvider::class,
                    $this->getClassName($userProvider)
                )
            );
        }


        return $userProvider->loadUserByUsername($credentials->getUsername(), $credentials);
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

    public function getClassName($class): string
    {
        $className = new \ReflectionClass($class);

        return $className->getName();
    }
}