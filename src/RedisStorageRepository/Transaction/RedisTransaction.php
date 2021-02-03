<?php

declare(strict_types=1);

namespace App\RedisStorageRepository\Transaction;

interface RedisTransaction
{
    public function multi();

    public function set(string $key);

    public function get(string $value);

    public function discard();

    public function unwatch();

    public function exec();
}