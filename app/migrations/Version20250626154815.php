<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626154815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cards (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, card VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, INDEX IDX_4C258FD54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hand (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, card VARCHAR(255) NOT NULL, INDEX IDX_2762428F99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, winner VARCHAR(255) DEFAULT NULL, `rank` VARCHAR(255) NOT NULL, INDEX IDX_98197A6554177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, number_participant VARCHAR(255) NOT NULL, ready TINYINT(1) DEFAULT NULL, goal VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE round (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, player_id INT DEFAULT NULL, block VARCHAR(255) NOT NULL, INDEX IDX_C5EEEA3454177093 (room_id), INDEX IDX_C5EEEA3499E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `table` (id INT AUTO_INCREMENT NOT NULL, round_id INT DEFAULT NULL, cards VARCHAR(255) NOT NULL, INDEX IDX_F6298F46A6005CA0 (round_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, timeround DATETIME DEFAULT NULL, lie TINYINT(1) DEFAULT NULL, INDEX IDX_6F94984554177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cards ADD CONSTRAINT FK_4C258FD54177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE hand ADD CONSTRAINT FK_2762428F99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A6554177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE round ADD CONSTRAINT FK_C5EEEA3454177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE round ADD CONSTRAINT FK_C5EEEA3499E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE `table` ADD CONSTRAINT FK_F6298F46A6005CA0 FOREIGN KEY (round_id) REFERENCES round (id)');
        $this->addSql('ALTER TABLE time ADD CONSTRAINT FK_6F94984554177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cards DROP FOREIGN KEY FK_4C258FD54177093');
        $this->addSql('ALTER TABLE hand DROP FOREIGN KEY FK_2762428F99E6F5DF');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A6554177093');
        $this->addSql('ALTER TABLE round DROP FOREIGN KEY FK_C5EEEA3454177093');
        $this->addSql('ALTER TABLE round DROP FOREIGN KEY FK_C5EEEA3499E6F5DF');
        $this->addSql('ALTER TABLE `table` DROP FOREIGN KEY FK_F6298F46A6005CA0');
        $this->addSql('ALTER TABLE time DROP FOREIGN KEY FK_6F94984554177093');
        $this->addSql('DROP TABLE cards');
        $this->addSql('DROP TABLE hand');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE round');
        $this->addSql('DROP TABLE `table`');
        $this->addSql('DROP TABLE time');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
