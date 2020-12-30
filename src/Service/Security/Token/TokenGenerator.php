<?php

declare(strict_types=1);

namespace App\Service\Security\Token;

use App\Entity\Security\Token;
use App\Service\Security\Token\Interfaces\SignatureGenerate;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

final class TokenGenerator implements SignatureGenerate
{
    private TokenGeneratorInterface $randomstring;

    public function __construct(TokenGeneratorInterface $randomstring)
    {
        $this->randomstring = $randomstring;
    }

    public function generate(int $length): string
    {
        return substr($this->randomstring->generateToken(), 0, Token::SIGNATURE_LENGTH);
    }
}