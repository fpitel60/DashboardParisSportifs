<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210127135315 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE league ADD country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C318F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_3EB4C318F92F3E70 ON league (country_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE league DROP FOREIGN KEY FK_3EB4C318F92F3E70');
        $this->addSql('DROP INDEX IDX_3EB4C318F92F3E70 ON league');
        $this->addSql('ALTER TABLE league DROP country_id');
    }
}
