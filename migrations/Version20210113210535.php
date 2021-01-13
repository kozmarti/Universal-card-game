<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113210535 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, user_discard_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, is_in_deck TINYINT(1) NOT NULL, is_discard TINYINT(1) NOT NULL, is_visible TINYINT(1) NOT NULL, is_played TINYINT(1) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_161498D3A76ED395 (user_id), INDEX IDX_161498D3995EEE42 (user_discard_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3995EEE42 FOREIGN KEY (user_discard_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3A76ED395');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3995EEE42');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE user');
    }
}
