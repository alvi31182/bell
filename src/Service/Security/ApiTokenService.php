<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Entity\Security\Device;
use App\Entity\Security\Token;
use App\Event\Security\Token\TokenEvent;
use App\RedisStorageRepository\RedisReadStorage;
use App\Repository\Security\DeviceReadStorage;
use App\Repository\Security\TokenReadStorage;
use App\Repository\Security\TokenWriteStorage;
use App\Service\Security\Token\Interfaces\SignatureGenerate;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class ApiTokenService
{
    private TokenReadStorage $tokeReadStorage;
    private DeviceReadStorage $deviceReadStorage;
    private TokenWriteStorage $tokenWriteStorage;
    private RedisReadStorage $redisReadStorage;
    private SignatureGenerate $signatureGenerate;
    private EntityManagerInterface $em;
    private EventDispatcherInterface $dispatch;

    public function __construct(
        TokenReadStorage $tokenReadStorage,
        DeviceReadStorage $deviceReadStorage,
        TokenWriteStorage $tokenWriteStorage,
        RedisReadStorage $redisReadStorage,
        SignatureGenerate $signatureGenerate,
        EntityManagerInterface $em,
        EventDispatcherInterface $dispatch
    ) {
        $this->tokeReadStorage = $tokenReadStorage;
        $this->deviceReadStorage = $deviceReadStorage;
        $this->tokenWriteStorage = $tokenWriteStorage;
        $this->redisReadStorage = $redisReadStorage;
        $this->signatureGenerate = $signatureGenerate;
        $this->em = $em;
        $this->dispatch = $dispatch;
    }

    /**
     * @param UuidInterface $id
     * @param \DateInterval $dateInterval
     * @return string
     */
    public function updateToken(UuidInterface $id, \DateInterval $dateInterval): string
    {
        $token = $this->tokeReadStorage->findById($id);

        $newToken = $this->signatureGenerate->generate(Token::SIGNATURE_LENGTH);

        $token->updateToken($newToken, $dateInterval);

        $this->tokenWriteStorage->update($token);

        $event = new TokenEvent($token->getId()->toString(), $newToken);

        $this->dispatch->dispatch($event, TokenEvent::NAME);

        $this->em->flush();

        return $this->returnNewToken($event);
    }

    public function returnNewToken(TokenEvent $event): string
    {
        return $this->redisReadStorage->get($event->getId());
    }

    public function resetToken(string $token){
        $oldToken = $this->findByToken($token);
        $oldToken->markAsExpired();
        $this->em->flush();
    }

    public function getApiToken($tokenId)
    {
        $this->tokeReadStorage->findById($tokenId);
    }

    public function findByToken($token): ?Token
    {
        return $this->tokeReadStorage->findByToken($token);
    }
}