<?php

declare(strict_types=1);

namespace App\Data\Author;

use App\Entity\Authors\Author;

final class AuthorData
{
    private $name;

    public function __construct(Author $author)
    {
        $this->name = $author->getName();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}