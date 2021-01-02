<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Entity\Security\Device;
use App\Entity\Security\Token;
use App\Entity\Security\User;
use App\Repository\Security\Device\DeviceWriteStorage;
use App\Repository\Security\DeviceReadStorage;
use App\Repository\Security\User\UserReadStorage;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Request;

final class DeviceService
{
    private DeviceReadStorage $deviceReadStorage;
    private DeviceWriteStorage $deviceWriteStorage;
    private UserReadStorage $userReadStorage;

    public function __construct(
        DeviceReadStorage $deviceReadStorage,
        DeviceWriteStorage $deviceWriteStorage,
        UserReadStorage $userReadStorage
    ) {
        $this->deviceReadStorage = $deviceReadStorage;
        $this->deviceWriteStorage = $deviceWriteStorage;
        $this->userReadStorage = $userReadStorage;
    }

    public function create(User $user, Token $token)
    {
        $hardwareId = Request::createFromGlobals()->headers->get('User-Agent');

        $device = new Device(
            Uuid::uuid4(),
            $user,
            $token,
            $hardwareId,
            'tt'
        );

        $this->deviceWriteStorage->add($device);
    }
}