<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260517125957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add nullable tech_stack column to project table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE project ADD COLUMN tech_stack CLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__project AS SELECT id, title, description, images, position, created_at, github_url, is_active FROM project');
        $this->addSql('DROP TABLE project');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, images CLOB NOT NULL, position INTEGER NOT NULL, created_at DATETIME NOT NULL, github_url VARCHAR(255) DEFAULT NULL, is_active BOOLEAN DEFAULT 1 NOT NULL)');
        $this->addSql('INSERT INTO project (id, title, description, images, position, created_at, github_url, is_active) SELECT id, title, description, images, position, created_at, github_url, is_active FROM __temp__project');
        $this->addSql('DROP TABLE __temp__project');
    }
}
