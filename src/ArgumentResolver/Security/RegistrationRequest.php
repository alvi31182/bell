<?php

declare(strict_types=1);

namespace App\ArgumentResolver\Security;

use App\Data\User\UserRegistrationData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

final class RegistrationRequest implements ArgumentValueResolverInterface
{

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return UserRegistrationData::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        $user = $this->serializer->deserialize($request->getContent(),UserRegistrationData::class,'json');

        yield $user;
    }
}