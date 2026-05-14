<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260513230000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add hero image transform fields on profile (x, y, scale).';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE profile ADD hero_image_x INTEGER DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE profile ADD hero_image_y INTEGER DEFAULT -120 NOT NULL');
        $this->addSql('ALTER TABLE profile ADD hero_image_scale INTEGER DEFAULT 120 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE profile DROP hero_image_x');
        $this->addSql('ALTER TABLE profile DROP hero_image_y');
        $this->addSql('ALTER TABLE profile DROP hero_image_scale');
    }
}
