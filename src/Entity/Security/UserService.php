<?php

declare(strict_types=1);

namespace App\Entity\Security;

use App\Data\User\UserRegistrationData;
use App\Repository\Security\User\UserReadStorage;
use App\Service\Security\Exception\UserExistsException;
use App\Service\Security\Interfaces\UserRegistrationInterface;
use App\Transaction\TransactionManager\TransactionManager;

final class UserService implements UserRegistrationInterface
{
    private UserReadStorage $readStorage;
    private TransactionManager $transaction;

    public function __construct(UserReadStorage $readStorage, TransactionManager $transaction)
    {
        $this->readStorage = $readStorage;
        $this->transaction = $transaction;
    }

    public function register(UserRegistrationData $data): void
    {
        $user = $this->readStorage->findByEmail($data->getEmail());

        if ($user) {
            throw new UserExistsException(sprintf('This user already exists'));
        }
    }
}