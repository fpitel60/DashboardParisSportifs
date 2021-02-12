<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210205125155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet ADD typebet_id INT DEFAULT NULL, DROP type_bet');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9B5C45B74D FOREIGN KEY (typebet_id) REFERENCES type_bet (id)');
        $this->addSql('CREATE INDEX IDX_FBF0EC9B5C45B74D ON bet (typebet_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9B5C45B74D');
        $this->addSql('DROP INDEX IDX_FBF0EC9B5C45B74D ON bet');
        $this->addSql('ALTER TABLE bet ADD type_bet INT NOT NULL, DROP typebet_id');
    }
}
