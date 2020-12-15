<?php

namespace App\DataFixtures;

use App\Entity\Security\User;
use App\Entity\Security\Token;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $adminId = Uuid::uuid4();
        $adminEmail = 'admin@mail.ru';
        $adminName = 'Administrator';
        $adminLastName = 'Adminstratorovich';
        $adminPassword = $this->encodePassword('administrator');
        $roleAdmin = ['ROLE_ADMIN'];
        $tokenTtl = new \DateInterval("PT1H");

        $admin = new User(
            $adminId,
            $adminEmail,
            $adminName,
            $adminLastName,
            $adminPassword,
            $roleAdmin
        );
        $tokenAdmin = new Token($admin,$tokenTtl);
        $manager->persist($tokenAdmin);

        $userId = Uuid::uuid4();
        $userEmail = 'user@mail.ru';
        $userName = 'User';
        $userLastName = 'Userovich';
        $userPassword = $this->encodePassword('userfirst');
        $roleUser = ['ROLE_USER'];

        $user = new User(
            $userId,
            $userEmail,
            $userName,
            $userLastName,
            $userPassword,
            $roleUser
        );

        $token = new Token($user, $tokenTtl);

        $manager->persist($token);

        $manager->flush();
    }

    public function encodePassword(string $password): string
    {
        return password_hash($password,PASSWORD_DEFAULT);
    }
}
