<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210218142430 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_test ADD palier_montante_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bet_test ADD CONSTRAINT FK_FDA9AD30EDA41384 FOREIGN KEY (palier_montante_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FDA9AD30EDA41384 ON bet_test (palier_montante_id)');
        $this->addSql('ALTER TABLE palier_montante ADD montante_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE palier_montante ADD CONSTRAINT FK_20DF9D7AEA058415 FOREIGN KEY (montante_id) REFERENCES montante (id)');
        $this->addSql('CREATE INDEX IDX_20DF9D7AEA058415 ON palier_montante (montante_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_test DROP FOREIGN KEY FK_FDA9AD30EDA41384');
        $this->addSql('DROP INDEX IDX_FDA9AD30EDA41384 ON bet_test');
        $this->addSql('ALTER TABLE bet_test DROP palier_montante_id');
        $this->addSql('ALTER TABLE palier_montante DROP FOREIGN KEY FK_20DF9D7AEA058415');
        $this->addSql('DROP INDEX IDX_20DF9D7AEA058415 ON palier_montante');
        $this->addSql('ALTER TABLE palier_montante DROP montante_id');
    }
}
