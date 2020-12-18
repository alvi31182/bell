<?php

declare(strict_types=1);

namespace App\Service\Security\Token\Interfaces;

interface SignatureGenerate
{
    public function generate(int $length);
}