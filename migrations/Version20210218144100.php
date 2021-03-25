<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210218144100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE montante ADD user_id INT DEFAULT NULL, CHANGE date_debut date_start DATETIME NOT NULL');
        $this->addSql('ALTER TABLE montante ADD CONSTRAINT FK_DAC62143A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DAC62143A76ED395 ON montante (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE montante DROP FOREIGN KEY FK_DAC62143A76ED395');
        $this->addSql('DROP INDEX IDX_DAC62143A76ED395 ON montante');
        $this->addSql('ALTER TABLE montante DROP user_id, CHANGE date_start date_debut DATETIME NOT NULL');
    }
}
