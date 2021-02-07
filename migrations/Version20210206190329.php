<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210206190329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creating Books and Authors';
    }

    public function up(Schema $schema) : void
    {

        $quantity = 10;

        for ($i = 0; $i < $quantity; $i++) {

            $bookId = Uuid::uuid4()->toString();
            $authorId = Uuid::uuid4()->toString();

            $ru_title = "Поваренная книга-$i";
            $en_title = "Cook Book-$i";
            $created_at = '2020-11-18 22:50:07.262450';
            $authorName = "Born-$i";

            $dataBook = ['id' => $bookId, 'ru_title' => $ru_title, 'en_title' => $en_title, 'created_at' => $created_at];
            $dataAuthor = ['id' => $authorId, 'name' => $authorName, 'created_at' => $created_at];

            $bookIdAuthorId = ['book_id' => $bookId, 'author_id' => $authorId];
            $authorIdBooksId = ['author_id' => $authorId, 'book_id' => $bookId];

            $this->connection->insert('books', $dataBook);
            $this->connection->insert('authors', $dataAuthor);
            $this->connection->insert('book_authors', $bookIdAuthorId);
            $this->connection->insert('author_books',$authorIdBooksId);

        }
    }

    public function down(Schema $schema) : void
    {

    }
}
