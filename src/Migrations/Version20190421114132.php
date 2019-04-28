<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190421114132 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE participation_request (id INT AUTO_INCREMENT NOT NULL, id_participant_id INT NOT NULL, id_experience_id INT NOT NULL, validated INT NOT NULL, INDEX IDX_70E93E5EA07A8D1F (id_participant_id), INDEX IDX_70E93E5EF8C1DF42 (id_experience_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE researcher (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, department VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, researcher_id INT NOT NULL, compensation DOUBLE PRECISION DEFAULT NULL, place VARCHAR(255) NOT NULL, feedback LONGTEXT DEFAULT NULL, free_req TINYINT(1) NOT NULL, age_req INT DEFAULT NULL, sex_req VARCHAR(255) DEFAULT NULL, specifiq_req LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, date_debut DATETIME DEFAULT NULL, datefin DATETIME DEFAULT NULL, INDEX IDX_590C103C7533BDE (researcher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, in_relation_with_id INT NOT NULL, created_at DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307F18EC68A7 (in_relation_with_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, age INT NOT NULL, sex VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant_experience (participant_id INT NOT NULL, experience_id INT NOT NULL, INDEX IDX_3950271D9D1C3019 (participant_id), INDEX IDX_3950271D46E90E27 (experience_id), PRIMARY KEY(participant_id, experience_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant_message (participant_id INT NOT NULL, message_id INT NOT NULL, INDEX IDX_2CB0FF779D1C3019 (participant_id), INDEX IDX_2CB0FF77537A1329 (message_id), PRIMARY KEY(participant_id, message_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participation_request ADD CONSTRAINT FK_70E93E5EA07A8D1F FOREIGN KEY (id_participant_id) REFERENCES participant (id)');
        $this->addSql('ALTER TABLE participation_request ADD CONSTRAINT FK_70E93E5EF8C1DF42 FOREIGN KEY (id_experience_id) REFERENCES experience (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103C7533BDE FOREIGN KEY (researcher_id) REFERENCES researcher (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES researcher (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F18EC68A7 FOREIGN KEY (in_relation_with_id) REFERENCES experience (id)');
        $this->addSql('ALTER TABLE participant_experience ADD CONSTRAINT FK_3950271D9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_experience ADD CONSTRAINT FK_3950271D46E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_message ADD CONSTRAINT FK_2CB0FF779D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_message ADD CONSTRAINT FK_2CB0FF77537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103C7533BDE');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE participation_request DROP FOREIGN KEY FK_70E93E5EF8C1DF42');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F18EC68A7');
        $this->addSql('ALTER TABLE participant_experience DROP FOREIGN KEY FK_3950271D46E90E27');
        $this->addSql('ALTER TABLE participant_message DROP FOREIGN KEY FK_2CB0FF77537A1329');
        $this->addSql('ALTER TABLE participation_request DROP FOREIGN KEY FK_70E93E5EA07A8D1F');
        $this->addSql('ALTER TABLE participant_experience DROP FOREIGN KEY FK_3950271D9D1C3019');
        $this->addSql('ALTER TABLE participant_message DROP FOREIGN KEY FK_2CB0FF779D1C3019');
        $this->addSql('DROP TABLE participation_request');
        $this->addSql('DROP TABLE researcher');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE participant_experience');
        $this->addSql('DROP TABLE participant_message');
    }
}
