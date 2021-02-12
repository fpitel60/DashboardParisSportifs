<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210132504 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_test (id INT AUTO_INCREMENT NOT NULL, bettest_id INT DEFAULT NULL, date DATE NOT NULL, name VARCHAR(255) NOT NULL, choix VARCHAR(255) NOT NULL, cote DOUBLE PRECISION NOT NULL, result_bet TINYINT(1) DEFAULT NULL, INDEX IDX_336A12208B473C9D (bettest_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_test ADD CONSTRAINT FK_336A12208B473C9D FOREIGN KEY (bettest_id) REFERENCES bet_test (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game_test');
    }
}
