<?php

declare(strict_types=1);

namespace App\Transaction\TransactionHandler;

interface TransactionHandler
{
    public function begin();
    public function commit();
    public function rollback();
    public function clear();
}