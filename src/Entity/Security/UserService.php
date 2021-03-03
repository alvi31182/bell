<?php

declare(strict_types=1);

namespace App\Entity\Security;

use App\Data\User\UserRegistrationData;
use App\Entity\Security\ValueObjects\Email;
use App\Repository\Security\User\UserReadStorage;
use App\Repository\Security\User\UserWriteStorage;
use App\Service\Security\Exception\UserExistsException;
use App\Service\Security\Interfaces\UserRegistrationInterface;
use App\Transaction\TransactionManager\TransactionManager;
use Ramsey\Uuid\Uuid;

final class UserService implements UserRegistrationInterface
{
    private UserReadStorage $readStorage;
    private TransactionManager $transaction;
    private UserWriteStorage $writeStorage;

    public function __construct(
        UserReadStorage $readStorage,
        TransactionManager $transaction,
        UserWriteStorage $writeStorage
    ) {
        $this->readStorage = $readStorage;
        $this->transaction = $transaction;
        $this->writeStorage = $writeStorage;
    }

    /**
     * @param UserRegistrationData $data
     * @throws UserExistsException
     * @throws \Throwable
     */
    public function register(UserRegistrationData $data): void
    {
        $user = $this->readStorage->findByEmail($data->getEmail());

        if ($user) {
            throw new UserExistsException(sprintf('This user already exists'));
        }

        $this->transaction->transaction(
            fn() =>  $this->writeStorage->add(
                new User(
                    Uuid::uuid4(),
                    new Email($data->getEmail()),
                    $data->getFirstName(),
                    $data->getLastName(),
                    $data->getPassword(),
                    UserStatus::moderate(),
                    ['ROLE_USER'],
                )
            )
        );
    }
}