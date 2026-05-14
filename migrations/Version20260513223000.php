<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260513223000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add tools_skills to profile for a third explicit skills category.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE profile ADD tools_skills CLOB DEFAULT '[]' NOT NULL");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE profile DROP tools_skills');
    }
}
