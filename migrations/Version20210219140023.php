<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210219140023 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_test DROP FOREIGN KEY FK_FDA9AD30EDA41384');
        $this->addSql('ALTER TABLE bet_test ADD CONSTRAINT FK_FDA9AD30EDA41384 FOREIGN KEY (palier_montante_id) REFERENCES palier_montante (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_test DROP FOREIGN KEY FK_FDA9AD30EDA41384');
        $this->addSql('ALTER TABLE bet_test ADD CONSTRAINT FK_FDA9AD30EDA41384 FOREIGN KEY (palier_montante_id) REFERENCES user (id)');
    }
}
