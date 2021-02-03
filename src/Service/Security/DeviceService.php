<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Entity\Security\Token;
use App\Entity\Security\User;
use App\Event\Security\DeviceEvent;
use App\Repository\Security\DeviceReadStorage;
use App\Repository\Security\User\UserReadStorage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class DeviceService
{
    private DeviceReadStorage $deviceReadStorage;
    private UserReadStorage $userReadStorage;
    private EventDispatcherInterface $dispatch;

    public function __construct(
        DeviceReadStorage $deviceReadStorage,
        UserReadStorage $userReadStorage,
        EventDispatcherInterface $dispatch
    )
    {
        $this->deviceReadStorage = $deviceReadStorage;
        $this->userReadStorage = $userReadStorage;
        $this->dispatch = $dispatch;
    }

    public function create(User $user, Token $token): void
    {
        $hardwareId = Request::createFromGlobals()->headers->get('User-Agent');

        $token->createDevice($user, $hardwareId);

        $device = $this->deviceReadStorage->findById($user->getId()->toString());

        $event = new DeviceEvent(
            $device->getId()->toString(),
            $device->getHardwareId(),
            $device->getName(),
            $device->getToken()->getToken(),
            $device->getCreatedAt()
        );

        $this->dispatch->dispatch($event, DeviceEvent::NAME);
    }
}