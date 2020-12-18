<?php

declare(strict_types=1);

namespace App\Repository\Author;

use App\Entity\Authors\Author;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

interface AuthorReadStorage
{
    public function getByName(string $name): array;
    public function getId(UuidInterface $id): Author;
}