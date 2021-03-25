<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210218134911 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE montante (id INT AUTO_INCREMENT NOT NULL, date_debut DATETIME NOT NULL, nb_palier INT NOT NULL, mise_start INT NOT NULL, objectif INT DEFAULT NULL, result_montante VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palier_montante (id INT AUTO_INCREMENT NOT NULL, number_palier INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bet_game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_test CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE type_bet_final ADD sport_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_bet_final ADD CONSTRAINT FK_7759B782AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('CREATE INDEX IDX_7759B782AC78BCF8 ON type_bet_final (sport_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE montante');
        $this->addSql('DROP TABLE palier_montante');
        $this->addSql('DROP TABLE type_bet_game');
        $this->addSql('ALTER TABLE game_test CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE type_bet_final DROP FOREIGN KEY FK_7759B782AC78BCF8');
        $this->addSql('DROP INDEX IDX_7759B782AC78BCF8 ON type_bet_final');
        $this->addSql('ALTER TABLE type_bet_final DROP sport_id');
    }
}
