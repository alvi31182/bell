<?php

declare(strict_types=1);

namespace App\Repository\Security;

use App\Entity\Security\Device;

interface DeviceReadStorage
{
    public function findById(string $id): ?Device;
    public function findByTokenId(string $tokenId): ?Device;
}