<?php

declare(strict_types=1);

namespace App\Repository\Author;

use App\Entity\Authors\Author;

interface AuthorReadStorage
{
    public function getByName(string $name): array;
}