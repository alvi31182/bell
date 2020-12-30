<?php

declare(strict_types=1);

namespace App\ArgumentResolver\Security;

use App\Data\User\UserLoginRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class LoginArgumentResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return UserLoginRequest::class === $argument->getType();
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return \Generator
     * @throws \JsonException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        $content = json_decode($request->getContent(),true, 512, JSON_THROW_ON_ERROR);

        yield new UserLoginRequest(
            $content['email'],
            $content['password']
        );
    }
}