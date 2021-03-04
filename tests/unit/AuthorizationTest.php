<?php

declare(strict_types=1);

namespace App\Tests\unit;

use App\Entity\Security\UserService;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorizationTest extends WebTestCase
{

    public function testUserService()
    {
        $client = static::createClient();
        dd($client);
    }
}