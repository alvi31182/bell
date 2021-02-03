<?php

declare(strict_types=1);

namespace App\Repository\Security;

use App\Entity\Security\Token;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;

class ApiTokenRepository extends ServiceEntityRepository implements TokenReadStorage, TokenWriteStorage
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Token::class);
    }

    public function findById(UuidInterface $id): ?Token
    {
        return $this->find($id);
    }

    public function getAndLock(UuidInterface $id): ?Token
    {
        return $this->find($id . LockMode::PESSIMISTIC_READ);
    }

    /**
     * @param Token $token
     * @throws ORMException
     */
    public function add(Token $token): void
    {
        $this->getEntityManager()->persist($token);
    }

    /**
     * @param Token $token
     * @throws ORMException
     */
    public function update(Token $token): void
    {
        $this->getEntityManager()->persist($token);
    }

    public function findByToken(string $token): ?Token
    {
        $foundToken = $this->findOneBy(['token' => $token]);

        if(!$foundToken){
            throw new TokenNotFoundException(sprintf('This token not found'));
        }

        return $foundToken;
    }

    public function findByTokenUserId(string $deviceId): ?Token
    {
        return $this->findOneBy(['device' => $deviceId]);
    }
}