<?php

declare(strict_types=1);

namespace App\Transaction;

use App\Transaction\TransactionHandler\TransactionHandler;
use App\Transaction\TransactionManager\TransactionManager;

final class Transaction
{
    private TransactionHandler $transactionHandler;
    private TransactionManager $transactionManager;

    public function __construct(TransactionHandler $transactionHandler, TransactionManager $transactionManager)
    {
        $this->transactionHandler = $transactionHandler;
        $this->transactionManager = $transactionManager;
    }

}