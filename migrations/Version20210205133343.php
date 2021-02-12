<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210205133343 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE highlight CHANGE type_highlight_id type_highlight_id INT DEFAULT NULL, CHANGE game_id game_id INT DEFAULT NULL, CHANGE player_id player_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE highlight ADD CONSTRAINT FK_C998D834755566D1 FOREIGN KEY (type_highlight_id) REFERENCES type_highlight (id)');
        $this->addSql('ALTER TABLE highlight ADD CONSTRAINT FK_C998D834E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE highlight ADD CONSTRAINT FK_C998D83499E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_C998D834755566D1 ON highlight (type_highlight_id)');
        $this->addSql('CREATE INDEX IDX_C998D834E48FD905 ON highlight (game_id)');
        $this->addSql('CREATE INDEX IDX_C998D83499E6F5DF ON highlight (player_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE highlight DROP FOREIGN KEY FK_C998D834755566D1');
        $this->addSql('ALTER TABLE highlight DROP FOREIGN KEY FK_C998D834E48FD905');
        $this->addSql('ALTER TABLE highlight DROP FOREIGN KEY FK_C998D83499E6F5DF');
        $this->addSql('DROP INDEX IDX_C998D834755566D1 ON highlight');
        $this->addSql('DROP INDEX IDX_C998D834E48FD905 ON highlight');
        $this->addSql('DROP INDEX IDX_C998D83499E6F5DF ON highlight');
        $this->addSql('ALTER TABLE highlight CHANGE type_highlight_id type_highlight_id INT NOT NULL, CHANGE game_id game_id INT NOT NULL, CHANGE player_id player_id INT NOT NULL');
    }
}
