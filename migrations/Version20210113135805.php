<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113135805 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cards (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, player_discard_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, is_in_deck TINYINT(1) NOT NULL, is_discard TINYINT(1) NOT NULL, INDEX IDX_4C258FD99E6F5DF (player_id), INDEX IDX_4C258FD619CAC93 (player_discard_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cards ADD CONSTRAINT FK_4C258FD99E6F5DF FOREIGN KEY (player_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE cards ADD CONSTRAINT FK_4C258FD619CAC93 FOREIGN KEY (player_discard_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cards DROP FOREIGN KEY FK_4C258FD99E6F5DF');
        $this->addSql('ALTER TABLE cards DROP FOREIGN KEY FK_4C258FD619CAC93');
        $this->addSql('DROP TABLE cards');
        $this->addSql('DROP TABLE `user`');
    }
}
