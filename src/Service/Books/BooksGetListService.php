<?php

declare(strict_types=1);

namespace App\Service\Books;

use App\Data\Book\BookData;
use App\Entity\Books\Book;
use App\Repository\Book\BookReadStorage;

final class BooksGetListService
{
    private BookReadStorage $bookReadStorage;

    public function __construct(BookReadStorage $bookReadStorage)
    {
        $this->bookReadStorage = $bookReadStorage;
    }

    public function findBook(string $title): ?array
    {
        return $this->bookReadStorage->findByName($title);
    }

}