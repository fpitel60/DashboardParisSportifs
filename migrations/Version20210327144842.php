<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210327144842 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bankroll (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, visibility VARCHAR(255) NOT NULL, start_bankroll DOUBLE PRECISION NOT NULL, current_bankroll DOUBLE PRECISION NOT NULL, mises_cumul DOUBLE PRECISION DEFAULT NULL, benefs_cumul DOUBLE PRECISION DEFAULT NULL, roi DOUBLE PRECISION DEFAULT NULL, roc DOUBLE PRECISION DEFAULT NULL, INDEX IDX_9C0FA5AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bet (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, typebet_id INT DEFAULT NULL, date DATETIME NOT NULL, result_bet TINYINT(1) DEFAULT NULL, INDEX IDX_FBF0EC9BA76ED395 (user_id), INDEX IDX_FBF0EC9B5C45B74D (typebet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bet_test (id INT AUTO_INCREMENT NOT NULL, bankroll_id INT DEFAULT NULL, palier_montante_id INT DEFAULT NULL, date DATETIME NOT NULL, result_bet VARCHAR(255) DEFAULT NULL, cote DOUBLE PRECISION DEFAULT NULL, mise DOUBLE PRECISION NOT NULL, gain DOUBLE PRECISION DEFAULT NULL, INDEX IDX_FDA9AD30725DA5D8 (bankroll_id), UNIQUE INDEX UNIQ_FDA9AD30EDA41384 (palier_montante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE choice_bet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, home_team_id INT DEFAULT NULL, foreign_team_id INT DEFAULT NULL, league_id INT DEFAULT NULL, date DATETIME NOT NULL, score VARCHAR(255) DEFAULT NULL, INDEX IDX_232B318C9C4C13F6 (home_team_id), INDEX IDX_232B318CB30270C6 (foreign_team_id), INDEX IDX_232B318C58AFC4DE (league_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_test (id INT AUTO_INCREMENT NOT NULL, bettest_id INT DEFAULT NULL, date DATETIME NOT NULL, name VARCHAR(255) NOT NULL, choix VARCHAR(255) NOT NULL, cote DOUBLE PRECISION DEFAULT NULL, result_bet VARCHAR(255) DEFAULT NULL, INDEX IDX_336A12208B473C9D (bettest_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE highlight (id INT AUTO_INCREMENT NOT NULL, type_highlight_id INT DEFAULT NULL, game_id INT DEFAULT NULL, player_id INT DEFAULT NULL, result_highlight TINYINT(1) DEFAULT NULL, INDEX IDX_C998D834755566D1 (type_highlight_id), INDEX IDX_C998D834E48FD905 (game_id), INDEX IDX_C998D83499E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league (id INT AUTO_INCREMENT NOT NULL, sport_id INT DEFAULT NULL, country_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3EB4C318AC78BCF8 (sport_id), INDEX IDX_3EB4C318F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE montante (id INT AUTO_INCREMENT NOT NULL, bankroll_id INT DEFAULT NULL, date_start DATETIME NOT NULL, nb_palier INT NOT NULL, mise_start INT NOT NULL, objectif INT DEFAULT NULL, result_montante VARCHAR(255) DEFAULT NULL, gain DOUBLE PRECISION DEFAULT NULL, INDEX IDX_DAC62143725DA5D8 (bankroll_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palier_montante (id INT AUTO_INCREMENT NOT NULL, montante_id INT DEFAULT NULL, bet_test_id INT DEFAULT NULL, number_palier INT NOT NULL, INDEX IDX_20DF9D7AEA058415 (montante_id), UNIQUE INDEX UNIQ_20DF9D7AF689F9B5 (bet_test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, INDEX IDX_98197A65296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, league_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C4E0A61F58AFC4DE (league_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bet_final (id INT AUTO_INCREMENT NOT NULL, sport_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_7759B782AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bet_game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bet_highlight (id INT AUTO_INCREMENT NOT NULL, sport_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_88B2B594AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_by_bet_highlight (id INT AUTO_INCREMENT NOT NULL, type_bet_highlight_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F35F948B20865DC9 (type_bet_highlight_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_highlight (id INT AUTO_INCREMENT NOT NULL, sport_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, sign VARCHAR(255) DEFAULT NULL, nombre DOUBLE PRECISION NOT NULL, INDEX IDX_7D5E9924AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, default_bankroll_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649A6AEB66E (default_bankroll_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bankroll ADD CONSTRAINT FK_9C0FA5AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9B5C45B74D FOREIGN KEY (typebet_id) REFERENCES type_bet (id)');
        $this->addSql('ALTER TABLE bet_test ADD CONSTRAINT FK_FDA9AD30725DA5D8 FOREIGN KEY (bankroll_id) REFERENCES bankroll (id)');
        $this->addSql('ALTER TABLE bet_test ADD CONSTRAINT FK_FDA9AD30EDA41384 FOREIGN KEY (palier_montante_id) REFERENCES palier_montante (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C9C4C13F6 FOREIGN KEY (home_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CB30270C6 FOREIGN KEY (foreign_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE game_test ADD CONSTRAINT FK_336A12208B473C9D FOREIGN KEY (bettest_id) REFERENCES bet_test (id)');
        $this->addSql('ALTER TABLE highlight ADD CONSTRAINT FK_C998D834755566D1 FOREIGN KEY (type_highlight_id) REFERENCES type_highlight (id)');
        $this->addSql('ALTER TABLE highlight ADD CONSTRAINT FK_C998D834E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE highlight ADD CONSTRAINT FK_C998D83499E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C318AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C318F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE montante ADD CONSTRAINT FK_DAC62143725DA5D8 FOREIGN KEY (bankroll_id) REFERENCES bankroll (id)');
        $this->addSql('ALTER TABLE palier_montante ADD CONSTRAINT FK_20DF9D7AEA058415 FOREIGN KEY (montante_id) REFERENCES montante (id)');
        $this->addSql('ALTER TABLE palier_montante ADD CONSTRAINT FK_20DF9D7AF689F9B5 FOREIGN KEY (bet_test_id) REFERENCES bet_test (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE type_bet_final ADD CONSTRAINT FK_7759B782AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE type_bet_highlight ADD CONSTRAINT FK_88B2B594AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE type_by_bet_highlight ADD CONSTRAINT FK_F35F948B20865DC9 FOREIGN KEY (type_bet_highlight_id) REFERENCES type_bet_highlight (id)');
        $this->addSql('ALTER TABLE type_highlight ADD CONSTRAINT FK_7D5E9924AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A6AEB66E FOREIGN KEY (default_bankroll_id) REFERENCES bankroll (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_test DROP FOREIGN KEY FK_FDA9AD30725DA5D8');
        $this->addSql('ALTER TABLE montante DROP FOREIGN KEY FK_DAC62143725DA5D8');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A6AEB66E');
        $this->addSql('ALTER TABLE game_test DROP FOREIGN KEY FK_336A12208B473C9D');
        $this->addSql('ALTER TABLE palier_montante DROP FOREIGN KEY FK_20DF9D7AF689F9B5');
        $this->addSql('ALTER TABLE league DROP FOREIGN KEY FK_3EB4C318F92F3E70');
        $this->addSql('ALTER TABLE highlight DROP FOREIGN KEY FK_C998D834E48FD905');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C58AFC4DE');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F58AFC4DE');
        $this->addSql('ALTER TABLE palier_montante DROP FOREIGN KEY FK_20DF9D7AEA058415');
        $this->addSql('ALTER TABLE bet_test DROP FOREIGN KEY FK_FDA9AD30EDA41384');
        $this->addSql('ALTER TABLE highlight DROP FOREIGN KEY FK_C998D83499E6F5DF');
        $this->addSql('ALTER TABLE league DROP FOREIGN KEY FK_3EB4C318AC78BCF8');
        $this->addSql('ALTER TABLE type_bet_final DROP FOREIGN KEY FK_7759B782AC78BCF8');
        $this->addSql('ALTER TABLE type_bet_highlight DROP FOREIGN KEY FK_88B2B594AC78BCF8');
        $this->addSql('ALTER TABLE type_highlight DROP FOREIGN KEY FK_7D5E9924AC78BCF8');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C9C4C13F6');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CB30270C6');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65296CD8AE');
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9B5C45B74D');
        $this->addSql('ALTER TABLE type_by_bet_highlight DROP FOREIGN KEY FK_F35F948B20865DC9');
        $this->addSql('ALTER TABLE highlight DROP FOREIGN KEY FK_C998D834755566D1');
        $this->addSql('ALTER TABLE bankroll DROP FOREIGN KEY FK_9C0FA5AA76ED395');
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9BA76ED395');
        $this->addSql('DROP TABLE bankroll');
        $this->addSql('DROP TABLE bet');
        $this->addSql('DROP TABLE bet_test');
        $this->addSql('DROP TABLE choice_bet');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_test');
        $this->addSql('DROP TABLE highlight');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE montante');
        $this->addSql('DROP TABLE palier_montante');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE type_bet');
        $this->addSql('DROP TABLE type_bet_final');
        $this->addSql('DROP TABLE type_bet_game');
        $this->addSql('DROP TABLE type_bet_highlight');
        $this->addSql('DROP TABLE type_by_bet_highlight');
        $this->addSql('DROP TABLE type_highlight');
        $this->addSql('DROP TABLE user');
    }
}
