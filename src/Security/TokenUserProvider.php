<?php

declare(strict_types=1);

namespace App\Security;

use App\Data\User\UserData;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class TokenUserProvider implements UserProviderInterface
{
    /**
     * @var UserProvider[]
     */
    public $userProvider;

    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * @param string $username
     * @param UserData|null $data
     *
     * @return UserProvider|UserInterface
     *
     * @throws UsernameNotFoundException
     */
    public function loadUserByUsername(string $username, UserData $data = null)
    {

        if(isset($this->userProvider[$username])){
            return $this->userProvider[$username];
        }

        return $this->userProvider[$username] = new UserProvider($data);
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    /**
     * @param string $class
     *
     * @return string
     */
    public function supportsClass(string $class)
    {
        return UserProvider::class;
    }
}