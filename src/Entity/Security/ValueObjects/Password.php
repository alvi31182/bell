<?php

declare(strict_types=1);

namespace App\Entity\Security\ValueObjects;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
final class Password
{
    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    private string $password;

    public function __construct(string $password)
    {
        $this->password = $this->encodePassword($password);
    }

    public function encodePassword(string $password): string
    {
        return password_hash($password,PASSWORD_DEFAULT);
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}