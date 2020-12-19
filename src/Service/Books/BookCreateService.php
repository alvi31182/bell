<?php

declare(strict_types=1);

namespace App\Service\Books;

use App\Data\Book\RequestCreateBook;
use App\Entity\Authors\Author;
use App\Entity\Books\Book;
use App\Exceptions\AuthorException\AuthorNotFoundExceptions;
use App\Repository\Author\AuthorReadStorage;
use App\Repository\Book\BookWriteStorage;
use Doctrine\ORM\EntityManagerInterface;

final class BookCreateService
{
    /*private BookWriteStorage $writeStorage;
    private AuthorReadStorage $authorReadStorage;
    private EntityManagerInterface $em;

    public function __construct(
        BookWriteStorage $bookWriteStorage,
        AuthorReadStorage $authorReadStorage,
        EntityManagerInterface $em
    ) {
        $this->writeStorage = $bookWriteStorage;
        $this->authorReadStorage = $authorReadStorage;
        $this->em = $em;
    }


    public function create(RequestCreateBook $requestCreateBook): void
    {
        $author = $this->checkAuthor($requestCreateBook->getAuthor());

        $this->writeStorage->add(
            new Book(
                $requestCreateBook->getId(),
                $requestCreateBook->getRuTitle(),
                $requestCreateBook->getEnTitle(),
                $author
            )
        );

        $this->em->flush();
    }


    public function checkAuthor(string $name): array
    {
        $author = $this->authorReadStorage->getByName($name);
        if (empty($author)) {
            throw new AuthorNotFoundExceptions(sprintf('Данного автора с  %s не существует', $name));
        }
        return $author;
    }*/
}