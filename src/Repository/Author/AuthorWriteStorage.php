<?php

declare(strict_types=1);

namespace App\Repository\Author;

use App\Entity\Authors\Author;

interface AuthorWriteStorage
{
    public function add(Author $author): void;
}