<?php

declare(strict_types=1);

namespace App\Repository\Author;

use App\Entity\Authors\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\QueryException;
use Doctrine\Persistence\ManagerRegistry;

final class AuthorsRepository extends ServiceEntityRepository implements AuthorReadStorage
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
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
                ->getResult()
            ;
    }
}