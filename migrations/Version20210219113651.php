<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210219113651 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_test DROP INDEX IDX_FDA9AD30EDA41384, ADD UNIQUE INDEX UNIQ_FDA9AD30EDA41384 (palier_montante_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_test DROP INDEX UNIQ_FDA9AD30EDA41384, ADD INDEX IDX_FDA9AD30EDA41384 (palier_montante_id)');
    }
}
