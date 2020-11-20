<?php

declare(strict_types=1);

namespace App\Repository\Book;

use App\Entity\Books\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

final class BooksRepository extends ServiceEntityRepository implements BookReadStorage, BookWriteStorage
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param Book $book
     * @throws ORMException
     */
    public function add(Book $book): void
    {
        $this->getEntityManager()->persist($book);
    }

    /**
     * @param string $title
     * @return Book|null
     */
    public function findByName(string $title): ?array
    {
        $qb = $this->createQueryBuilder('u');

        return
            $qb->where('u.title LIKE :title')
                ->setParameter('title', '%' . $title . '%')
                ->getQuery()
                ->getResult();
    }
}