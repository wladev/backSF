<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531133910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD post_by_id INT DEFAULT NULL, ADD guest_name VARCHAR(255) DEFAULT NULL, ADD guest_title VARCHAR(255) DEFAULT NULL, ADD guest_company VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA73DFCACEB FOREIGN KEY (post_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA73DFCACEB ON event (post_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA73DFCACEB');
        $this->addSql('DROP INDEX IDX_3BAE0AA73DFCACEB ON event');
        $this->addSql('ALTER TABLE event DROP post_by_id, DROP guest_name, DROP guest_title, DROP guest_company');
    }
}
