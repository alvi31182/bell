<?php

declare(strict_types=1);

namespace App\RedisStorageRepository;

use App\Service\Redis\RedisClientService;

class TokenDataItem implements RedisReadStorage, RedisWriteStorage
{
    private RedisClientService $redisClientService;

    public function __construct(RedisClientService $redisClientService)
    {
        $this->redisClientService = $redisClientService;
    }

    public function hSet(object $event): void
    {
        $this->redisClientService->redisConnection()->hSet('event_id', $event->getDevice()->getId()->toString(), $event);
    }

    public function set(string $key, $value): void
    {
        $this->redisClientService->redisConnection()->set($key, $value);
    }

    /**
     * @param string $key
     * @return string
     * @throws \RedisException
     */
    public function get(string $key): string
    {
        $result = $this->redisClientService->redisConnection()->get($key);

        if (!$result) {
            throw new \RedisException(sprintf('Not value key from redis %s', $result));
        }

        return $result;
    }

    /**
     * @param string $key
     * @param $value
     * @return string
     * @throws \RedisException
     */
    public function hGet(string $key, $value): string
    {
        $result_hGet = $this->redisClientService->redisConnection()->hGet($key, $value);

        if(!$result_hGet){
            throw new \RedisException(sprintf('Not result from hGet from redis store %s', $result_hGet));
        }

        return $result_hGet;
    }
}