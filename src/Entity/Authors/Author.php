<?php

declare(strict_types=1);

namespace App\Entity\Authors;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Author\AuthorsRepository;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass=AuthorsRepository::class)
 * @ORM\Table(name="authors")
 */
final class Author
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
    private string $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Books\Book", cascade={"persist","merge"}, inversedBy="author", fetch="LAZY")
     * @ORM\JoinTable(name="author_books",
     *      joinColumns={@ORM\JoinColumn(name="author_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")}
     * )
     */
    private Collection $book;

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

    public function __construct(UuidInterface $id, string $name, Collection $book, \DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->book = $book;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdateAt(): \DateTimeImmutable
    {
        return $this->updateAt;
    }
}