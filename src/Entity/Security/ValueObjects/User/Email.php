<?php


namespace App\Entity\Security\ValueObjects\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Email
{
    private string $email;

    public function __construct(string $email)
    {
        $this->validationEmail($email);
        $this->email = $email;
    }

    public function validationEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}