<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210220122332 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bankroll (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_bankroll DOUBLE PRECISION NOT NULL, current_bankroll DOUBLE PRECISION NOT NULL, mises_cumul DOUBLE PRECISION DEFAULT NULL, benef_cumul DOUBLE PRECISION DEFAULT NULL, roi DOUBLE PRECISION DEFAULT NULL, roc DOUBLE PRECISION DEFAULT NULL, INDEX IDX_9C0FA5AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bankroll ADD CONSTRAINT FK_9C0FA5AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bet_test DROP FOREIGN KEY FK_FDA9AD30A76ED395');
        $this->addSql('DROP INDEX IDX_FDA9AD30A76ED395 ON bet_test');
        $this->addSql('ALTER TABLE bet_test CHANGE user_id bankroll_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bet_test ADD CONSTRAINT FK_FDA9AD30725DA5D8 FOREIGN KEY (bankroll_id) REFERENCES bankroll (id)');
        $this->addSql('CREATE INDEX IDX_FDA9AD30725DA5D8 ON bet_test (bankroll_id)');
        $this->addSql('ALTER TABLE montante DROP FOREIGN KEY FK_DAC62143A76ED395');
        $this->addSql('DROP INDEX IDX_DAC62143A76ED395 ON montante');
        $this->addSql('ALTER TABLE montante CHANGE user_id bankroll_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE montante ADD CONSTRAINT FK_DAC62143725DA5D8 FOREIGN KEY (bankroll_id) REFERENCES bankroll (id)');
        $this->addSql('CREATE INDEX IDX_DAC62143725DA5D8 ON montante (bankroll_id)');
        $this->addSql('ALTER TABLE user ADD default_bankroll_id INT DEFAULT NULL, DROP benefs_cumul, DROP mises_cumul, DROP roi, DROP start_bankroll, DROP roc, DROP current_bankroll');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A6AEB66E FOREIGN KEY (default_bankroll_id) REFERENCES bankroll (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A6AEB66E ON user (default_bankroll_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_test DROP FOREIGN KEY FK_FDA9AD30725DA5D8');
        $this->addSql('ALTER TABLE montante DROP FOREIGN KEY FK_DAC62143725DA5D8');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A6AEB66E');
        $this->addSql('DROP TABLE bankroll');
        $this->addSql('DROP INDEX IDX_FDA9AD30725DA5D8 ON bet_test');
        $this->addSql('ALTER TABLE bet_test CHANGE bankroll_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bet_test ADD CONSTRAINT FK_FDA9AD30A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FDA9AD30A76ED395 ON bet_test (user_id)');
        $this->addSql('DROP INDEX IDX_DAC62143725DA5D8 ON montante');
        $this->addSql('ALTER TABLE montante CHANGE bankroll_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE montante ADD CONSTRAINT FK_DAC62143A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DAC62143A76ED395 ON montante (user_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649A6AEB66E ON user');
        $this->addSql('ALTER TABLE user ADD benefs_cumul DOUBLE PRECISION DEFAULT NULL, ADD mises_cumul DOUBLE PRECISION DEFAULT NULL, ADD roi DOUBLE PRECISION DEFAULT NULL, ADD start_bankroll DOUBLE PRECISION DEFAULT NULL, ADD roc DOUBLE PRECISION DEFAULT NULL, ADD current_bankroll DOUBLE PRECISION DEFAULT NULL, DROP default_bankroll_id');
    }
}
