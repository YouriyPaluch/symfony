<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230716152930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_codes DROP FOREIGN KEY FK_2009AE3AA76ED395');
        $this->addSql('DROP INDEX IDX_2009AE3AA76ED395 ON url_codes');
        $this->addSql('ALTER TABLE url_codes ADD user INT NOT NULL, DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_codes ADD user_id INT DEFAULT NULL, DROP user');
        $this->addSql('ALTER TABLE url_codes ADD CONSTRAINT FK_2009AE3AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2009AE3AA76ED395 ON url_codes (user_id)');
    }
}
