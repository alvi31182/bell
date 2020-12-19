<?php

declare(strict_types=1);

namespace App\Data\Book;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RequestCreateBook
{
    private UuidInterface $id;
    private ?string $ru_title;
    private ?string $en_title;
    private string $author;

    public function __construct(?string $ru_title, ?string $en_title, string $author)
    {
        $this->id = Uuid::uuid4();
        $this->ru_title = $ru_title;
        $this->en_title = $en_title;
        $this->author = $author;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRuTitle(): ?string
    {
        return $this->ru_title;
    }

    public function getEnTitle(): ?string
    {
        return $this->en_title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }
}