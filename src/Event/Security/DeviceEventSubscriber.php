<?php

declare(strict_types=1);

namespace App\Event\Security;

use App\RedisStorageRepository\RedisReadStorage;
use App\RedisStorageRepository\RedisWriteStorage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Serializer\SerializerInterface;

class DeviceEventSubscriber implements EventSubscriberInterface
{
    private RedisWriteStorage $redisWriteEvent;
    private RedisReadStorage $redisReadStorage;
    private SerializerInterface $serializer;

    public function __construct(
        RedisWriteStorage $redisWriteEvent,
        RedisReadStorage $redisReadStorage,
        SerializerInterface $serializer
    ) {
        $this->redisWriteEvent = $redisWriteEvent;
        $this->redisReadStorage = $redisReadStorage;
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            DeviceEvent::NAME => [
                ['onDeviceStore', 99],
                ['getDeviceEvent', 98]
            ],
        ];
    }

    public function onDeviceStore(DeviceEvent $event)
    {

        $eventData = $this->serializer->serialize($event,'json');

        $this->redisWriteEvent->set('deviceEvent', $eventData);

    }

    /**
     * @return string
     */
    public function getDeviceEvent(): string
    {
        $deviceStoreResult = $this->redisReadStorage->get('deviceEvent');

        $data = $this->serializer->serialize($deviceStoreResult,'json');

        return $data;
    }

    public function determineEventObject()
    {
    }
}