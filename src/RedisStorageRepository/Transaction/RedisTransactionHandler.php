<?php

declare(strict_types=1);

namespace App\RedisStorageRepository\Transaction;

final class RedisTransactionHandler
{
    private RedisTransaction $redisTransaction;

    public function __construct(RedisTransaction $redisTransaction)
    {
        $this->redisTransaction = $redisTransaction;
    }

    /**
     * @param callable $function
     * @return false|mixed
     * @throws \RedisException
     */
    public function redisTransaction(callable $function): bool
    {
        $this->multi();

        $result = null;

        try {
            $result = call_user_func($function);
        } catch (\RedisException $redisException) {
            $this->unwatch();
            $this->discard();
            throw $redisException;
        }

        $this->exec();

        return $result;
    }

    public function multi()
    {
        $this->redisTransaction->multi();
    }

    public function set(string $key)
    {
        $this->redisTransaction->set($key);
    }

    public function get(string $value)
    {
        $this->redisTransaction->get($value);
    }

    public function discard()
    {
        $this->redisTransaction->discard();
    }

    public function unwatch()
    {
        $this->redisTransaction->unwatch();
    }

    public function exec()
    {
        $this->redisTransaction->exec();
    }
}