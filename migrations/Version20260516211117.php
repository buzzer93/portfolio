<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260516211117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__profile AS SELECT id, about_text, photo_path, cv_path, frontend_skills, backend_skills, tools_skills, hero_image_x, hero_image_y, hero_image_scale FROM profile');
        $this->addSql('DROP TABLE profile');
        $this->addSql('CREATE TABLE profile (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, about_text CLOB NOT NULL, photo_path VARCHAR(255) DEFAULT NULL, cv_path VARCHAR(255) DEFAULT NULL, frontend_skills CLOB NOT NULL, backend_skills CLOB NOT NULL, tools_skills CLOB NOT NULL, hero_image_x INTEGER DEFAULT 0 NOT NULL, hero_image_y INTEGER DEFAULT -120 NOT NULL, hero_image_scale INTEGER DEFAULT 120 NOT NULL)');
        $this->addSql('INSERT INTO profile (id, about_text, photo_path, cv_path, frontend_skills, backend_skills, tools_skills, hero_image_x, hero_image_y, hero_image_scale) SELECT id, about_text, photo_path, cv_path, frontend_skills, backend_skills, tools_skills, hero_image_x, hero_image_y, hero_image_scale FROM __temp__profile');
        $this->addSql('DROP TABLE __temp__profile');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project AS SELECT id, title, description, images, position, created_at, github_url, is_active FROM project');
        $this->addSql('DROP TABLE project');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, images CLOB NOT NULL, position INTEGER NOT NULL, created_at DATETIME NOT NULL, github_url VARCHAR(255) DEFAULT NULL, is_active BOOLEAN DEFAULT 1 NOT NULL)');
        $this->addSql('INSERT INTO project (id, title, description, images, position, created_at, github_url, is_active) SELECT id, title, description, images, position, created_at, github_url, is_active FROM __temp__project');
        $this->addSql('DROP TABLE __temp__project');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__profile AS SELECT id, about_text, photo_path, cv_path, frontend_skills, backend_skills, tools_skills, hero_image_x, hero_image_y, hero_image_scale FROM profile');
        $this->addSql('DROP TABLE profile');
        $this->addSql('CREATE TABLE profile (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, about_text CLOB NOT NULL, photo_path VARCHAR(255) DEFAULT NULL, cv_path VARCHAR(255) DEFAULT NULL, frontend_skills CLOB NOT NULL, backend_skills CLOB NOT NULL, tools_skills CLOB DEFAULT \'[]\' NOT NULL, hero_image_x INTEGER DEFAULT 0 NOT NULL, hero_image_y INTEGER DEFAULT -120 NOT NULL, hero_image_scale INTEGER DEFAULT 120 NOT NULL)');
        $this->addSql('INSERT INTO profile (id, about_text, photo_path, cv_path, frontend_skills, backend_skills, tools_skills, hero_image_x, hero_image_y, hero_image_scale) SELECT id, about_text, photo_path, cv_path, frontend_skills, backend_skills, tools_skills, hero_image_x, hero_image_y, hero_image_scale FROM __temp__profile');
        $this->addSql('DROP TABLE __temp__profile');
        $this->addSql('ALTER TABLE project ADD COLUMN tech_stack CLOB NOT NULL');
    }
}
