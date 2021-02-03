<?php

declare(strict_types=1);

namespace App\Service\Redis;

use Symfony\Component\Cache\Adapter\RedisAdapter;

final class RedisClientService
{
    private string $redisDsn;

    public function __construct(string $redisDsn)
    {
        $this->redisDsn = $redisDsn;
        $this->isValid($redisDsn);
    }

    public function getPort(): int
    {
        return $this->port ?? 6379;
    }

    public function isValid($dsn): bool
    {

        if (0 !== strpos($dsn, 'redis://')) {
            return false;
        }

        return false;
    }

    public function redisConnection()
    {
        return RedisAdapter::createConnection($this->getRedisDsn());
    }

    public function getRedisDsn(): string
    {
        return $this->redisDsn;
    }
}