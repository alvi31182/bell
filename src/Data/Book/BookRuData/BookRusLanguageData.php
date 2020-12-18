<?php

declare(strict_types=1);

namespace App\Data\Book\BookRuData;

use App\Entity\Authors\Author;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

final class BookRusLanguageData
{
    private UuidInterface $id;
    private string $ruTitle;
    private Collection $author;
    private \DateTimeImmutable $createdAt;

    /**
     * @param UuidInterface $id
     * @param string $ruTitle
     * @param Collection $author
     * @param \DateTimeImmutable $createdAt
     */
    public function __construct(UuidInterface $id, string $ruTitle, Collection $author, \DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->ruTitle = $ruTitle;
        $this->author = $author;
        $this->createdAt = $createdAt;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRuTitle(): string
    {
        return $this->ruTitle;
    }

    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}