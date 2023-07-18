<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230716113634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(60) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, status SMALLINT DEFAULT 0 NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE url_codes ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE url_codes ADD CONSTRAINT FK_2009AE3AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_2009AE3AA76ED395 ON url_codes (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_codes DROP FOREIGN KEY FK_2009AE3AA76ED395');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP INDEX IDX_2009AE3AA76ED395 ON url_codes');
        $this->addSql('ALTER TABLE url_codes DROP user_id');
    }
}
