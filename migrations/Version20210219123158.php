<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210219123158 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE palier_montante ADD bet_test_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE palier_montante ADD CONSTRAINT FK_20DF9D7AF689F9B5 FOREIGN KEY (bet_test_id) REFERENCES bet_test (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_20DF9D7AF689F9B5 ON palier_montante (bet_test_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE palier_montante DROP FOREIGN KEY FK_20DF9D7AF689F9B5');
        $this->addSql('DROP INDEX UNIQ_20DF9D7AF689F9B5 ON palier_montante');
        $this->addSql('ALTER TABLE palier_montante DROP bet_test_id');
    }
}
