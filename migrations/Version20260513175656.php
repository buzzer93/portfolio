<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260513175656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__profile AS SELECT id, about_text, photo_path, cv_path, frontend_skills, backend_skills FROM profile');
        $this->addSql('DROP TABLE profile');
        $this->addSql('CREATE TABLE profile (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, about_text CLOB NOT NULL, photo_path VARCHAR(255) DEFAULT NULL, cv_path VARCHAR(255) DEFAULT NULL, frontend_skills CLOB NOT NULL, backend_skills CLOB NOT NULL)');
        $this->addSql('INSERT INTO profile (id, about_text, photo_path, cv_path, frontend_skills, backend_skills) SELECT id, about_text, photo_path, cv_path, frontend_skills, backend_skills FROM __temp__profile');
        $this->addSql('DROP TABLE __temp__profile');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__profile AS SELECT id, about_text, photo_path, cv_path, frontend_skills, backend_skills FROM profile');
        $this->addSql('DROP TABLE profile');
        $this->addSql('CREATE TABLE profile (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, about_text CLOB NOT NULL, photo_path VARCHAR(255) DEFAULT NULL, cv_path VARCHAR(255) DEFAULT NULL, frontend_skills CLOB DEFAULT \'[]\' NOT NULL, backend_skills CLOB DEFAULT \'[]\' NOT NULL)');
        $this->addSql('INSERT INTO profile (id, about_text, photo_path, cv_path, frontend_skills, backend_skills) SELECT id, about_text, photo_path, cv_path, frontend_skills, backend_skills FROM __temp__profile');
        $this->addSql('DROP TABLE __temp__profile');
    }
}
