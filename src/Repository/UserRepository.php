<?php

namespace App\Repository;

use App\Entity\Security\User;
use App\Repository\Security\User\UserReadStorage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserReadStorage, UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }


    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findById(UuidInterface $id): ?User
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param string $password
     * @return User
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function checkUserPassword(string $password): User
    {
        return $this->createQueryBuilder('up')
            ->addCriteria(
                Criteria::create()->andWhere(Criteria::expr()->eq('password', $password))
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function loadUserByUsername(string $usernameOrEmail)
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u FROM App\Entity\User u WHERE u.email = :query'
        )
            ->setParameter('query', $usernameOrEmail)
            ->getOneOrNullResult();
    }
}
