<?php

declare(strict_types=1);

namespace App\Transaction\TransactionManager;

use App\Transaction\TransactionHandler\TransactionHandler;
use Doctrine\ORM\EntityManagerInterface;

final class TransactionManager implements TransactionHandler
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function begin()
    {
        $this->getEntityManager()->beginTransaction();
    }

    public function commit()
    {
        $this->getEntityManager()->flush();
        $this->getEntityManager()->commit();
        $this->clear();
    }

    public function rollback()
    {
        $this->clear();
        $this->getEntityManager()->rollback();
    }

    public function clear()
    {
        if(!$this->getEntityManager()->getConnection()->isTransactionActive()){
            $this->getEntityManager()->clear();
        }
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
}