<?php

declare(strict_types=1);

namespace App\Service\Authors;

use App\Entity\Authors\Author;
use App\Repository\Author\AuthorReadStorage;
use App\Repository\Author\AuthorWriteStorage;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class AuthorCreateService
{
    private AuthorReadStorage $authorReadStorage;
    private AuthorWriteStorage $authorWriteStorage;
    private EntityManagerInterface $em;

    /**
     * @param AuthorReadStorage $authorReadStorage
     * @param AuthorWriteStorage $authorWriteStorage
     * @param EntityManagerInterface $em
     */
    public function __construct(
        AuthorReadStorage $authorReadStorage,
        AuthorWriteStorage $authorWriteStorage,
        EntityManagerInterface $em
    ) {
        $this->authorReadStorage = $authorReadStorage;
        $this->authorWriteStorage = $authorWriteStorage;
        $this->em = $em;
    }

    public function create(AuthorCreateRequest $request): UuidInterface
    {

    }
}