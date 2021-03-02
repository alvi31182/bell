<?php

declare(strict_types=1);

namespace App\Data\User;

final class UserRegistrationData
{
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;

    /**
     * UserRegistrationData constructor.
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     */
    public function __construct(string $firstName, string $lastName, string $email, string $password)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}