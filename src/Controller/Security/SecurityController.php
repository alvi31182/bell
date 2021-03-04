<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Data\User\UserLoginRequest;
use App\Service\Security\AuthenticatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/auth")
 */
class SecurityController extends AbstractController
{
    private AuthenticatorService $authenticatorService;
    private SerializerInterface $serializer;
    private EventDispatcherInterface $dispatch;

    /**
     * @param AuthenticatorService $authenticatorService
     * @param SerializerInterface $serializer
     */
    public function __construct(AuthenticatorService $authenticatorService, SerializerInterface $serializer, EventDispatcherInterface $dispatch)
    {
        $this->authenticatorService = $authenticatorService;
        $this->serializer = $serializer;
        $this->dispatch = $dispatch;
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

        return new JsonResponse(["token" => $token], Response::HTTP_OK, []);
    }

    /**
     * @Route("/logout", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $getTokenFromHeader = $request->headers->get('Authorization');

        $token = explode(' ', $getTokenFromHeader);

        $this->authenticatorService->logoutUser($token[1]);

        return new JsonResponse();
    }
}