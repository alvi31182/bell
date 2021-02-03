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

    /**
     * @param callable $function
     * @return bool
     * @throws \Throwable
     */
    public function transaction(callable $function): bool
    {
        $this->begin();
        $result = null;
        try {
            $result = call_user_func($function);
        } catch (\Throwable $e) {
            $this->rollback();
            throw $e;
        }
        $this->commit();
        return $result;
    }

    public function begin()
    {
        $this->em->beginTransaction();
    }

    public function commit()
    {
        $this->em->flush();
        $this->em->commit();
        $this->clear();
    }

    public function rollback()
    {
        $this->clear();
        $this->em->rollback();
    }

    public function clear()
    {
        if(!$this->em->getConnection()->isTransactionActive()){
            $this->em->clear();
        }
    }
}