<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Data\Book\RequestCreateBook;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class CreateBookArgumentResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return RequestCreateBook::class === $argument->getType();
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return \Generator|iterable
     * @throws \JsonException
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $content = $content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        yield new RequestCreateBook(
            $content["title"],
            $content["author"]
        );
    }
}