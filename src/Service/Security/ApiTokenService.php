<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Entity\Security\Device;
use App\Entity\Security\Token;
use App\Repository\Security\DeviceReadStorage;
use App\Repository\Security\TokenReadStorage;
use App\Repository\Security\TokenWriteStorage;
use App\Service\Security\Token\Interfaces\SignatureGenerate;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class ApiTokenService
{
    private TokenReadStorage $tokeReadStorage;
    private DeviceReadStorage $deviceReadStorage;
    private TokenWriteStorage $tokenWriteStorage;
    private SignatureGenerate $signatureGenerate;
    private EntityManagerInterface $em;

    public function __construct(
        TokenReadStorage $tokenReadStorage,
        DeviceReadStorage $deviceReadStorage,
        TokenWriteStorage $tokenWriteStorage,
        SignatureGenerate $signatureGenerate,
        EntityManagerInterface $em
    ) {
        $this->tokeReadStorage = $tokenReadStorage;
        $this->deviceReadStorage = $deviceReadStorage;
        $this->tokenWriteStorage = $tokenWriteStorage;
        $this->signatureGenerate = $signatureGenerate;
        $this->em = $em;
    }

    public function getApiToken($token)
    {
        $this->tokeReadStorage->findById($token);
    }

    public function findByToken($token): ?Token
    {
        return $this->tokeReadStorage->findByToken($token);
    }

    /**
     * @param UuidInterface $id
     * @param \DateInterval $dateInterval
     * @return string
     */
    public function updateToken(UuidInterface $id, \DateInterval $dateInterval): string
    {
        $token = $this->tokeReadStorage->findById($id);

        $token->updateToken($this->signatureGenerate->generate(Token::SIGNATURE_LENGTH), $dateInterval);

        $this->tokenWriteStorage->update($token);

        $this->em->flush();

        return $token->getToken();
    }
}