<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602094432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA73DFCACEB');
        $this->addSql('DROP INDEX IDX_3BAE0AA73DFCACEB ON event');
        $this->addSql('ALTER TABLE event CHANGE post_by_id add_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA717542AC5 FOREIGN KEY (add_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA717542AC5 ON event (add_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA717542AC5');
        $this->addSql('DROP INDEX IDX_3BAE0AA717542AC5 ON event');
        $this->addSql('ALTER TABLE event CHANGE add_by_id post_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA73DFCACEB FOREIGN KEY (post_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA73DFCACEB ON event (post_by_id)');
    }
}
