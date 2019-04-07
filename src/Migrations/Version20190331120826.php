<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190331120826 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, in_relation_with_id INT NOT NULL, created_at DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307F18EC68A7 (in_relation_with_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, age INT NOT NULL, sex VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant_experience (participant_id INT NOT NULL, experience_id INT NOT NULL, INDEX IDX_3950271D9D1C3019 (participant_id), INDEX IDX_3950271D46E90E27 (experience_id), PRIMARY KEY(participant_id, experience_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant_message (participant_id INT NOT NULL, message_id INT NOT NULL, INDEX IDX_2CB0FF779D1C3019 (participant_id), INDEX IDX_2CB0FF77537A1329 (message_id), PRIMARY KEY(participant_id, message_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES researcher (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F18EC68A7 FOREIGN KEY (in_relation_with_id) REFERENCES experience (id)');
        $this->addSql('ALTER TABLE participant_experience ADD CONSTRAINT FK_3950271D9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_experience ADD CONSTRAINT FK_3950271D46E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_message ADD CONSTRAINT FK_2CB0FF779D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_message ADD CONSTRAINT FK_2CB0FF77537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experience ADD researcher_id INT NOT NULL, ADD specifi_req LONGTEXT DEFAULT NULL, DROP id_experience, DROP id_researcher, DROP specifiq_req, DROP name, CHANGE feedback feedback LONGTEXT DEFAULT NULL, CHANGE place place VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103C7533BDE FOREIGN KEY (researcher_id) REFERENCES researcher (id)');
        $this->addSql('CREATE INDEX IDX_590C103C7533BDE ON experience (researcher_id)');
        $this->addSql('ALTER TABLE researcher ADD lastname VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, DROP id_researcher, DROP last_name, DROP password, DROP first_name');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participant_message DROP FOREIGN KEY FK_2CB0FF77537A1329');
        $this->addSql('ALTER TABLE participant_experience DROP FOREIGN KEY FK_3950271D9D1C3019');
        $this->addSql('ALTER TABLE participant_message DROP FOREIGN KEY FK_2CB0FF779D1C3019');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE participant_experience');
        $this->addSql('DROP TABLE participant_message');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103C7533BDE');
        $this->addSql('DROP INDEX IDX_590C103C7533BDE ON experience');
        $this->addSql('ALTER TABLE experience ADD id_researcher INT NOT NULL, ADD specifiq_req VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP specifi_req, CHANGE place place VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE feedback feedback VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE researcher_id id_experience INT NOT NULL');
        $this->addSql('ALTER TABLE researcher ADD id_researcher INT NOT NULL, ADD last_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD first_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP lastname, DROP firstname');
    }
}
