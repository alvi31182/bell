<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Data\Author\AuthorCreateRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class CreateAuthorArgumentResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return AuthorCreateRequest::class === $argument->getType();
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return \Generator|iterable
     * @throws \JsonException
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        yield new AuthorCreateRequest(
            $content['name'] ?? null
        );
    }
}