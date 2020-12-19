<?php

declare(strict_types=1);

namespace App\Repository\Book;

use App\Entity\Books\Book;

interface BookReadStorage
{
    public function findByName(string $title): ?array;
}