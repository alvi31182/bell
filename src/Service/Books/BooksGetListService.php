<?php

declare(strict_types=1);

namespace App\Service\Books;

use App\Data\Book\BookRuData\BookRusLanguageData;
use App\Entity\Books\Book;
use App\Repository\Book\BookReadStorage;

final class BooksGetListService
{
    /*private BookReadStorage $bookReadStorage;

    public function __construct(BookReadStorage $bookReadStorage)
    {
        $this->bookReadStorage = $bookReadStorage;
    }

    public function findBook(string $title): ?array
    {
        return array_map([$this, 'mapData'], $this->bookReadStorage->findByName($title));
    }

    public function mapData(Book $book): BookRusLanguageData
    {
        return new BookRusLanguageData(
            $book->getId(),
            $book->getRuTitle(),
            $book->getAuthor(),
            $book->getCreatedAt()
        );
    }*/

}