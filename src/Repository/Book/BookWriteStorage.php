<?php

declare(strict_types=1);

namespace App\Repository\Book;

use App\Entity\Books\Book;

interface BookWriteStorage
{
    public function add(Book $book): void;
}