<?php

declare(strict_types=1);

namespace App\Security\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface TokenExtractor
{
    public function extract(Request $request): string;
}