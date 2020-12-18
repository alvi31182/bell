<?php

declare(strict_types=1);

namespace App\Service\Security;

use Symfony\Component\HttpFoundation\Request;

interface TokenExtractor
{
    /**
     * @param Request $request
     *
     * @return string
     */
    public function extract(Request $request): string;
}