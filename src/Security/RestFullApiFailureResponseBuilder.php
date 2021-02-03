<?php

declare(strict_types=1);

namespace App\Security;

use App\Security\Interfaces\AuthFailureResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class RestFullApiFailureResponseBuilder implements AuthFailureResponseBuilder
{

    public function unauthorized(AuthenticationException $e = null): Response
    {
        return new JsonResponse(
            $this->errorCode(401, 'Unauthorized access'), Response::HTTP_UNAUTHORIZED
        );
    }

    public function authFailure(AuthenticationException $e): Response
    {
        return new JsonResponse(
            $this->errorCode(401, 'Unauthorized access'), Response::HTTP_UNAUTHORIZED
        );
    }

    public function errorCode(int $code, string $message): array
    {
        return [
            "error" => [
                "code" => $code,
                "message" => $message
            ]
        ];
    }
}