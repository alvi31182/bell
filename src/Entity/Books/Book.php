<?php

declare(strict_types=1);

namespace App\Entity\Books;

use App\Entity\Authors\Author;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Book\BooksRepository;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass=BooksRepository::class)
 * @ORM\Table(name="books")
 */
final class Book
{
    /**
     * @var UuidInterface
     *
     * @ORM\Column(name="id", type="uuid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private UuidInterface $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private string $title;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="App\Entity\Authors\Author", cascade={"persist","merge"}, inversedBy="book", fetch="LAZY")
     * @ORM\JoinTable(name="book_authors",
     *      joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="author_id", referencedColumnName="id")}
     * )
     */
    private Collection $author;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetimetz_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @param UuidInterface $id
     * @param string $title
     * @param Collection $author
     */
    public function __construct(UuidInterface $id, string $title, Collection $author)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
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