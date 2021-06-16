<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210613001406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note CHANGE note_ds note_ds DOUBLE PRECISION DEFAULT NULL, CHANGE note_tp note_tp DOUBLE PRECISION DEFAULT NULL, CHANGE note_examen note_examen DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note CHANGE note_ds note_ds DOUBLE PRECISION NOT NULL, CHANGE note_tp note_tp DOUBLE PRECISION NOT NULL, CHANGE note_examen note_examen DOUBLE PRECISION NOT NULL');
    }
}
