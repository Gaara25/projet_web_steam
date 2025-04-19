<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414215412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, developer VARCHAR(255) NOT NULL, release_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE game_stat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, game_id INT DEFAULT NULL, hours_played INT NOT NULL, last_played DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_CBAD930DA76ED395 (user_id), INDEX IDX_CBAD930DE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game_stat ADD CONSTRAINT FK_CBAD930DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game_stat ADD CONSTRAINT FK_CBAD930DE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game_stat DROP FOREIGN KEY FK_CBAD930DA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE game_stat DROP FOREIGN KEY FK_CBAD930DE48FD905
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE comment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE game
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE game_stat
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
    }
}
