<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Data\User\UserData;
use App\Repository\Security\DeviceReadStorage;
use App\Repository\Security\User\UserReadStorage;
use App\Service\Security\Exception\NotFoundUserException;
use App\Service\Security\Exception\ValidationPasswordException;
use DateInterval;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;

final class AuthenticatorService
{
    private UserReadStorage $userReadStorage;
    private ApiTokenService $apiTokenService;
    private DateInterval $tokenTtl;
    private UserPasswordEncoderInterface $passwordEncode;
    private DeviceReadStorage $deviceReadStorage;
    private DeviceService $deviceService;
    private EventDispatcherInterface $dispatch;

    public function __construct(
        UserReadStorage $userReadStorage,
        ApiTokenService $apiTokenService,
        DateInterval $tokenTtl,
        UserPasswordEncoderInterface $passwordEncode,
        DeviceReadStorage $deviceReadStorage,
        DeviceService $deviceService,
        EventDispatcherInterface $dispatch
    ) {
        $this->userReadStorage = $userReadStorage;
        $this->apiTokenService = $apiTokenService;
        $this->tokenTtl = $tokenTtl;
        $this->passwordEncode = $passwordEncode;
        $this->deviceReadStorage = $deviceReadStorage;
        $this->deviceService = $deviceService;
        $this->dispatch = $dispatch;
    }

    /**
     * @param string $email
     * @param string $password
     * @return string
     * @throws \Exception
     */
    public function authenticateUser(string $email, string $password): string
    {
        $user = $this->userReadStorage->findByEmail($email);

        if (!$user) {
            throw new NotFoundUserException(sprintf('Password or Email not validation %s', $email));
        }

        $validPassword = $user->isPasswordValid($password);

        if (!$validPassword) {
            throw new ValidationPasswordException(sprintf('Password or Email not validation %s', substr($password, 2)));
        }

        $device = $this->deviceReadStorage->findById($user->getId()->toString());

        $this->deviceService->create($user,$device->getToken());

        return $this->apiTokenService->updateToken(
            $device->getToken()->getId(),
            $this->tokenTtl
        );
    }


    public function logoutUser(string $token)
    {
        $this->apiTokenService->resetToken($token);
    }
}