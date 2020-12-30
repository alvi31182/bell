<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Data\User\UserLoginRequest;
use App\Service\Security\AuthenticatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * @Route("/auth")
 */
class SecurityController extends AbstractController
{
    public AuthenticatorService $authenticatorService;

    /**
     * SecurityController constructor.
     * @param AuthenticatorService $authenticatorService
     */
    public function __construct(AuthenticatorService $authenticatorService)
    {
        $this->authenticatorService = $authenticatorService;
    }


    /**
     * @Route("/login", methods={"POST"})
     *
     * @param UserLoginRequest $userRequest
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function authenticate(UserLoginRequest $userRequest): JsonResponse
    {
        $token = $this->authenticatorService->authenticateUser(
            $userRequest->getEmail(),
            $userRequest->getPassword()
        );

        return new JsonResponse(["token" => $token], Response::HTTP_OK, [], false);
    }
}