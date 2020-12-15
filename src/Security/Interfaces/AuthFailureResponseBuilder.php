<?php

declare(strict_types=1);

namespace App\Security\Interfaces;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

interface AuthFailureResponseBuilder
{
    public function unauthorized(AuthenticationException $e = null): Response;

    public function authFailure(AuthenticationException $e): Response;
}