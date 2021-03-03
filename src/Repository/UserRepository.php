<?php

namespace App\Repository;

use App\Entity\Security\User;
use App\Repository\Security\User\UserReadStorage;
use App\Repository\Security\User\UserWriteStorage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\QueryException;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserReadStorage, UserWriteStorage, UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }


    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy(['email.email' => $email]);
    }

    public function findById(UuidInterface $id): ?User
    {
        return $this->find($id);
    }

    /**
     * @param string $password
     * @return User
     * @throws NonUniqueResultException
     * @throws QueryException
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

    /**
     * @param string $usernameOrEmail
     * @return int|mixed|string|UserInterface|null
     * @throws NonUniqueResultException
     */
    public function loadUserByUsername(string $usernameOrEmail)
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u FROM App\Entity\User u WHERE u.email = :query'
        )
            ->setParameter('query', $usernameOrEmail)
            ->getOneOrNullResult();
    }

    /**
     * @param User $user
     * @throws ORMException
     */
    public function add(User $user): void
    {
       $this->_em->persist($user);
    }
}
