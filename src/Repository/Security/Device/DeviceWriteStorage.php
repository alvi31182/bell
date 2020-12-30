<?php

declare(strict_types=1);

namespace App\Repository\Security\Device;

use App\Entity\Security\Device;

interface DeviceWriteStorage
{
    public function add(Device $device): void;
}