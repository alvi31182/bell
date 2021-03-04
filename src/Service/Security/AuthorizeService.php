<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Data\User\UserData;
use App\Entity\Security\Device;
use App\Entity\Security\Token;
use App\Entity\Security\User;
use App\Exceptions\AuthorException\TokenExpired;
use App\Repository\Security\DeviceReadStorage;
use App\Repository\Security\TokenReadStorage;
use App\Repository\Security\User\UserReadStorage;
use App\Service\Security\Exception\NotFoundUserException;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;

final class AuthorizeService
{
    private TokenReadStorage $tokenRadStorage;
    private UserReadStorage $userReadStorage;
    private DeviceReadStorage $deviceReadStorage;
    private Authorizer $authorize;

    public function __construct(
        TokenReadStorage $tokenRadStorage,
        UserReadStorage $userReadStorage,
        DeviceReadStorage $deviceReadStorage,
        Authorizer $authorize
    ) {
        $this->tokenRadStorage = $tokenRadStorage;
        $this->userReadStorage = $userReadStorage;
        $this->deviceReadStorage = $deviceReadStorage;
        $this->authorize = $authorize;
    }

    /**
     * @param string $rawToken
     *
     * @return UserData
     *
     * @throws TokenExpired
     */
    public function authorize(string $rawToken): UserData
    {
        $token = $this->authorize->authorization($rawToken);

        $device = $this->getUserIdFromDeviceManager($token);

        $userRole = $this->getUserRole($device->getUser()->getId());

        return new UserData(
            $device->getUser()->getId(),
            $token->getId(),
            $device->getId(),
            $userRole->getUsername(),
            $userRole->getRoles(),
            $device->getUser()->getStatus()->getRawValue()
        );
    }

    public function getUserIdFromDeviceManager(Token $token): Device
    {
        $device = $this->deviceReadStorage->findByTokenId($token->getId()->toString());

        if (!$device) {
            dd('');
        }

        return $device;
    }

    public function getUserRole(UuidInterface $userId): ?User
    {
        return $this->userReadStorage->findById($userId);
    }
}