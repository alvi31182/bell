<?php

declare(strict_types=1);

namespace App\Service\Books;

use App\Data\Book\RequestCreateBook;
use App\Entity\Books\Book;
use App\Repository\Author\AuthorReadStorage;
use App\Repository\Book\BookWriteStorage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

final class BookCreateService
{
    private BookWriteStorage $writeStorage;
    private AuthorReadStorage $authorReadStorage;
    private EntityManagerInterface $em;

    public function __construct(BookWriteStorage $bookWriteStorage, AuthorReadStorage $authorReadStorage,EntityManagerInterface $em)
    {
        $this->writeStorage = $bookWriteStorage;
        $this->authorReadStorage = $authorReadStorage;
        $this->em = $em;
    }

    /**
     * @param RequestCreateBook $requestCreateBook
     * @throws \Exception
     */
    public function create(RequestCreateBook $requestCreateBook)
    {
        $author = $this->authorReadStorage->getByName($requestCreateBook->getAuthor());

        if (!$author) {
            throw new \Exception(sprintf('Данного автора %s нет в системе',$requestCreateBook->getAuthor()));
        }

        $book = new Book(
            $requestCreateBook->getId(),
            $requestCreateBook->getTitle(),
            new ArrayCollection($author)
        );

        $this->writeStorage->add($book);
        $this->em->flush();
    }
}