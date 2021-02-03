<?php

declare(strict_types=1);

namespace App\Event\Security;

use App\Entity\Security\Device;
use App\Entity\Security\Token;
use App\Entity\Security\User;
use Symfony\Contracts\EventDispatcher\Event;

class DeviceEvent extends Event
{
    const NAME = 'device.event';

    private string $deviceId;
    private string $hardwareId;
    private string $deviseName;
    private string $token;
    private \DateTimeImmutable $createdAt;

    /**
     * DeviceEvent constructor.
     * @param string $deviceId
     * @param string $hardwareId
     * @param string $deviseName
     * @param string $token
     * @param \DateTimeImmutable $createdAt
     */
    public function __construct(
        string $deviceId,
        string $hardwareId,
        string $deviseName,
        string $token,
        \DateTimeImmutable $createdAt
    ) {
        $this->deviceId = $deviceId;
        $this->hardwareId = $hardwareId;
        $this->deviseName = $deviseName;
        $this->token = $token;
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    /**
     * @return string
     */
    public function getHardwareId(): string
    {
        return $this->hardwareId;
    }

    public function getToken(): string
    {
        return $this->token;
    }
    /**
     * @return string
     */
    public function getDeviseName(): string
    {
        return $this->deviseName;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

}