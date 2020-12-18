<?php

declare(strict_types=1);

namespace App\Repository\Book;

use App\Entity\Authors\Author;
use App\Entity\Books\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
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
            /*->addCriteria(
                Criteria::create()
                    ->andWhere(Criteria::expr()->eq('ru_title', $title))
                    ->orWhere(Criteria::expr()->eq('en_title', $title))
            )
            ->getQuery()
            ->getResult();*/
        return $qb
            ->select('b')
            ->from(Book::class,'ba')
            ->innerJoin('author.book','a',Join::WITH, 'ba.id = author')
            ->where('u.ru_title LIKE :ru_title')
            ->setParameter('ru_title', '%' . $title . '%')
            ->getQuery()
            ->getResult();
    }
}