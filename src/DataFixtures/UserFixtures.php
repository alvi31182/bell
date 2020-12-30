<?php

namespace App\DataFixtures;

use App\Entity\Security\Device;
use App\Entity\Security\User;
use App\Entity\Security\Token;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;
    private $request;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $request = new Request();
        $adminId = Uuid::uuid4();
        $adminEmail = 'admin@mail.ru';
        $adminName = 'Administrator';
        $adminLastName = 'Adminstratorovich';
        $adminPassword = $this->encodePassword('administrator');
        $adminToken = base64_encode(bin2hex(random_bytes(60)));
        $roleAdmin = ['ROLE_ADMIN'];
        $tokenTtl = new \DateInterval("PT1H");

        $deviceId = Uuid::uuid4();

        $admin = new User(
            $adminId,
            $adminEmail,
            $adminName,
            $adminLastName,
            $adminPassword,
            $roleAdmin
        );

        $tokenAdmin = new Token($adminToken,$tokenTtl);

        $deviceAdmin = new Device(
            $deviceId,
            $admin,
            $tokenAdmin,
            'browserid',
            'google',
            true
        );

        $manager->persist($deviceAdmin);

        $userId = Uuid::uuid4();
        $userEmail = 'user@mail.ru';
        $userName = 'User';
        $userLastName = 'Userovich';
        $userToken = base64_encode(bin2hex(random_bytes(60)));
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

        $deviceUserId = Uuid::uuid4();

        $tokenUser = new Token($userToken, $tokenTtl);

        $deviceUser= new Device(
            $deviceUserId,
            $user,
            $tokenUser,
            'browserid',
            'google',
            true
        );

        $manager->persist($deviceUser);

        $manager->flush();
    }

    public function encodePassword(string $password): string
    {
        return password_hash($password,PASSWORD_DEFAULT);
    }
}
