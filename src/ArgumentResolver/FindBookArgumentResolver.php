<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Data\Book\RequestBookData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class FindBookArgumentResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return RequestBookData::class === $argument->getType();
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return iterable|void
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield new RequestBookData(
            $request->get('title') ?? null
        );
    }
}