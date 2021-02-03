<?php

declare(strict_types=1);

namespace App\RedisStorageRepository;

interface RedisReadStorage
{
    public function get(string $key): string;
    public function hGet(string $key, $value);
}