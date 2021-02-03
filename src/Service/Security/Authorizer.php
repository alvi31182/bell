<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Entity\Security\Device;
use App\Entity\Security\Token;
use App\Exceptions\AuthorException\TokenExpired;
use App\Repository\Security\DeviceReadStorage;
use App\Repository\Security\TokenReadStorage;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;

final class Authorizer
{
    private TokenReadStorage $tokenReadStorage;
    private DeviceReadStorage $deviceReadStorage;

    public function __construct(TokenReadStorage $tokenReadStorage, DeviceReadStorage $deviceReadStorage)
    {
        $this->tokenReadStorage = $tokenReadStorage;
        $this->deviceReadStorage = $deviceReadStorage;
    }

    /**
     * @param string $rawToken
     * @return Token
     * @throws TokenExpired
     */
    public function authorization(string $rawToken): Token
    {
        $token = $this->tokenReadStorage->findByToken($rawToken);

        if (is_null($token)) {
            throw new TokenNotFoundException();
        }

        $token->authorize();
        $this->getUserIdFromDeviceManager($token);

        return $token;
    }

    public function getUserIdFromDeviceManager(Token $token): Device
    {
        $device = $this->deviceReadStorage->findByTokenId($token->getId()->toString());

        if (!$device) {
            dd('');
        }

        return $device;
    }
}