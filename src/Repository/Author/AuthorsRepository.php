<?php

declare(strict_types=1);

namespace App\Repository\Author;

use App\Entity\Authors\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\QueryException;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

final class AuthorsRepository extends ServiceEntityRepository implements AuthorReadStorage, AuthorWriteStorage
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function add(Author $author): void
    {
        // TODO: Implement add() method.
    }

    /**
     * @param string $name
     * @return array
     * @throws QueryException
     */
    public function getByName(string $name): array
    {
        return
            $this->createQueryBuilder('a')
                ->addCriteria(
                    Criteria::create()
                        ->andWhere(Criteria::expr()->eq('name', $name))
                )
                ->getQuery()
                ->getResult();
    }

    /**
     * @param UuidInterface $id
     * @return Author
     * @throws QueryException
     */
    public function getId(UuidInterface $id): Author
    {
        return $this->createQueryBuilder('a')
            ->addCriteria(
                Criteria::create()
                    ->andWhere(Criteria::expr()->eq('id', $id))
            )
            ->getQuery()
            ->getResult();
    }
}