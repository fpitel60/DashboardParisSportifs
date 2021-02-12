<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210205115251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_highlight ADD sport_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_highlight ADD CONSTRAINT FK_7D5E9924AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('CREATE INDEX IDX_7D5E9924AC78BCF8 ON type_highlight (sport_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_highlight DROP FOREIGN KEY FK_7D5E9924AC78BCF8');
        $this->addSql('DROP INDEX IDX_7D5E9924AC78BCF8 ON type_highlight');
        $this->addSql('ALTER TABLE type_highlight DROP sport_id');
    }
}
