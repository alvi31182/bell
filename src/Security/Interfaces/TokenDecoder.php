<?php

declare(strict_types=1);

namespace App\Security\Interfaces;

interface TokenDecoder
{
    public function decode();
}