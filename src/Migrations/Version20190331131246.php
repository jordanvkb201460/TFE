<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190331131246 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE participation_request (id INT AUTO_INCREMENT NOT NULL, id_participant_id INT NOT NULL, id_experience_id INT NOT NULL, validated TINYINT(1) NOT NULL, INDEX IDX_70E93E5EA07A8D1F (id_participant_id), INDEX IDX_70E93E5EF8C1DF42 (id_experience_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participation_request ADD CONSTRAINT FK_70E93E5EA07A8D1F FOREIGN KEY (id_participant_id) REFERENCES participant (id)');
        $this->addSql('ALTER TABLE participation_request ADD CONSTRAINT FK_70E93E5EF8C1DF42 FOREIGN KEY (id_experience_id) REFERENCES experience (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE participation_request');
    }
}
