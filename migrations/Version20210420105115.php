<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210420105115 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bookmaker (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bet_test ADD bookmaker_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bet_test ADD CONSTRAINT FK_FDA9AD308FB29728 FOREIGN KEY (bookmaker_id) REFERENCES bookmaker (id)');
        $this->addSql('CREATE INDEX IDX_FDA9AD308FB29728 ON bet_test (bookmaker_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_test DROP FOREIGN KEY FK_FDA9AD308FB29728');
        $this->addSql('DROP TABLE bookmaker');
        $this->addSql('DROP INDEX IDX_FDA9AD308FB29728 ON bet_test');
        $this->addSql('ALTER TABLE bet_test DROP bookmaker_id');
    }
}
