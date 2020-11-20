<?php

declare(strict_types=1);

namespace App\Data\Book;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RequestCreateBook
{
    private UuidInterface $id;
    private string $title;
    private string $author;

    public function __construct(string $title, string $author)
    {
        $this->id = Uuid::uuid4();
        $this->title = $title;
        $this->author = $author;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

}