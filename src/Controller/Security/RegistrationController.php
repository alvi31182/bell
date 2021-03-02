<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Data\User\UserRegistrationData;
use App\Service\Security\Interfaces\UserRegistrationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationController extends AbstractController
{
    private UserRegistrationInterface $registrationService;

    public function __construct(UserRegistrationInterface $registration)
    {
        $this->registrationService = $registration;
    }

    /**
     * @Route("/register", methods={"POST"})
     * @param UserRegistrationData $data
     */
    public function registerUser(UserRegistrationData $data): JsonResponse
    {
        $this->registrationService->register($data);

        return new JsonResponse(['registered' => 201]);
    }
}