<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260513193000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add github_url to project';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE project ADD COLUMN github_url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__project AS SELECT id, title, description, images, tech_stack, position, created_at FROM project');
        $this->addSql('DROP TABLE project');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, images CLOB NOT NULL, tech_stack CLOB NOT NULL, position INTEGER NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO project (id, title, description, images, tech_stack, position, created_at) SELECT id, title, description, images, tech_stack, position, created_at FROM __temp__project');
        $this->addSql('DROP TABLE __temp__project');
    }
}
