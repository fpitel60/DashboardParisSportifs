<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210217155328 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_bet_highlight (id INT AUTO_INCREMENT NOT NULL, sport_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_88B2B594AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_by_bet_highlight (id INT AUTO_INCREMENT NOT NULL, type_bet_highlight_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F35F948B20865DC9 (type_bet_highlight_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE type_bet_highlight ADD CONSTRAINT FK_88B2B594AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE type_by_bet_highlight ADD CONSTRAINT FK_F35F948B20865DC9 FOREIGN KEY (type_bet_highlight_id) REFERENCES type_bet_highlight (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_by_bet_highlight DROP FOREIGN KEY FK_F35F948B20865DC9');
        $this->addSql('DROP TABLE type_bet_highlight');
        $this->addSql('DROP TABLE type_by_bet_highlight');
    }
}
