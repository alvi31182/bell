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
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    private string $ru_title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    private string $en_title;

    /**
     * @var Collection
     *
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
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetimetz_immutable", nullable=true)
     */
    private \DateTimeImmutable $updateAt;

    /**
     * @param UuidInterface $id
     * @param string $ru_title
     * @param string $en_title
     * @param array $author
     */
    public function __construct(UuidInterface $id, string $ru_title, string $en_title, array $author)
    {
        $this->id = $id;
        $this->ru_title = $ru_title;
        $this->en_title = $en_title;
        $this->author = new ArrayCollection($author);
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRuTitle(): string
    {
        return $this->ru_title;
    }

    public function getEnTitle(): string
    {
        return $this->en_title;
    }

    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updateAt(): \DateTimeImmutable
    {
        return $this->updateAt;
    }
}