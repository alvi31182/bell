<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201118215616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE authors (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author_books (author_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', book_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_5C930A5FF675F31B (author_id), INDEX IDX_5C930A5F16A2B381 (book_id), PRIMARY KEY(author_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE books (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_authors (book_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', author_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_1D2C02C716A2B381 (book_id), INDEX IDX_1D2C02C7F675F31B (author_id), PRIMARY KEY(book_id, author_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE author_books ADD CONSTRAINT FK_5C930A5FF675F31B FOREIGN KEY (author_id) REFERENCES authors (id)');
        $this->addSql('ALTER TABLE author_books ADD CONSTRAINT FK_5C930A5F16A2B381 FOREIGN KEY (book_id) REFERENCES books (id)');
        $this->addSql('ALTER TABLE book_authors ADD CONSTRAINT FK_1D2C02C716A2B381 FOREIGN KEY (book_id) REFERENCES books (id)');
        $this->addSql('ALTER TABLE book_authors ADD CONSTRAINT FK_1D2C02C7F675F31B FOREIGN KEY (author_id) REFERENCES authors (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author_books DROP FOREIGN KEY FK_5C930A5FF675F31B');
        $this->addSql('ALTER TABLE book_authors DROP FOREIGN KEY FK_1D2C02C7F675F31B');
        $this->addSql('ALTER TABLE author_books DROP FOREIGN KEY FK_5C930A5F16A2B381');
        $this->addSql('ALTER TABLE book_authors DROP FOREIGN KEY FK_1D2C02C716A2B381');
        $this->addSql('DROP TABLE authors');
        $this->addSql('DROP TABLE author_books');
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE book_authors');
    }
}
