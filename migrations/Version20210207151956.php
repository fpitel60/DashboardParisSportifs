<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210207151956 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game CHANGE home_team_id home_team_id INT DEFAULT NULL, CHANGE foreign_team_id foreign_team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C9C4C13F6 FOREIGN KEY (home_team_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CB30270C6 FOREIGN KEY (foreign_team_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_232B318C9C4C13F6 ON game (home_team_id)');
        $this->addSql('CREATE INDEX IDX_232B318CB30270C6 ON game (foreign_team_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C9C4C13F6');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CB30270C6');
        $this->addSql('DROP INDEX IDX_232B318C9C4C13F6 ON game');
        $this->addSql('DROP INDEX IDX_232B318CB30270C6 ON game');
        $this->addSql('ALTER TABLE game CHANGE home_team_id home_team_id INT NOT NULL, CHANGE foreign_team_id foreign_team_id INT NOT NULL');
    }
}
