<?php

declare(strict_types=1);

namespace App\Event\Security\Token;

use App\RedisStorageRepository\RedisReadStorage;
use App\RedisStorageRepository\RedisWriteStorage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class TokenEventSubscriber implements EventSubscriberInterface
{

    private RedisWriteStorage $redisWriteStorage;
    private RedisReadStorage $redisReadStorage;
    private SerializerInterface $serializer;

    /**
     * @param RedisWriteStorage $redisWriteStorage
     * @param RedisReadStorage $redisReadStorage
     * @param SerializerInterface $serializer
     */
    public function __construct(
        RedisWriteStorage $redisWriteStorage,
        RedisReadStorage $redisReadStorage,
        SerializerInterface $serializer
    ) {
        $this->redisWriteStorage = $redisWriteStorage;
        $this->redisReadStorage = $redisReadStorage;
        $this->serializer = $serializer;
    }


    public static function getSubscribedEvents(): array
    {
        return [
            TokenEvent::NAME => [
                ['setTokenEvent', 98],
                ['getUpdatedToken', 97]
            ]
        ];
    }

    public function setTokenEvent(TokenEvent $event)
    {
        $data = $this->serializer->serialize($event, 'json');

        $this->redisWriteStorage->set($event->getId(), $data);
    }

    public function getUpdatedToken(TokenEvent $event)
    {
        $dts = $this->redisReadStorage->get($event->getId());
    }
}