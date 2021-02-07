<?php

declare(strict_types=1);

namespace App\RedisStorageRepository;

use App\Event\Security\DeviceEvent;

interface RedisWriteStorage
{
    public function hSet(object $event): void;
    public function set(string $key, $value): void;
}