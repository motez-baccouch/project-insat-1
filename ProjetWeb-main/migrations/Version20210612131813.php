<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210612131813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche_notes ADD matiere_id INT NOT NULL');
        $this->addSql('ALTER TABLE fiche_notes ADD CONSTRAINT FK_7B9B4CB3F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere_niveau_filiere (id)');
        $this->addSql('CREATE INDEX IDX_7B9B4CB3F46CD258 ON fiche_notes (matiere_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche_notes DROP FOREIGN KEY FK_7B9B4CB3F46CD258');
        $this->addSql('DROP INDEX IDX_7B9B4CB3F46CD258 ON fiche_notes');
        $this->addSql('ALTER TABLE fiche_notes DROP matiere_id');
    }
}
