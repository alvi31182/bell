<?php

declare(strict_types=1);

namespace App\Event\Security\Token;

use Symfony\Contracts\EventDispatcher\Event;

final class TokenEvent extends Event
{
    const NAME = 'token.event';

    private string $token;
    private string $id;

    public function __construct(string $id, string $token)
    {
        $this->id = $id;
        $this->token = $token;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}