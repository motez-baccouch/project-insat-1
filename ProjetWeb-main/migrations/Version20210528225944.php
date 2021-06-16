<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210528225944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite CHANGE doc_id doc_id INT DEFAULT NULL, CHANGE photo_id photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE download CHANGE doc_id doc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emploi_du_temps CHANGE doc_id doc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiche_notes1 CHANGE doc_id doc_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite CHANGE doc_id doc_id INT NOT NULL, CHANGE photo_id photo_id INT NOT NULL');
        $this->addSql('ALTER TABLE download CHANGE doc_id doc_id INT NOT NULL');
        $this->addSql('ALTER TABLE emploi_du_temps CHANGE doc_id doc_id INT NOT NULL');
        $this->addSql('ALTER TABLE fiche_notes1 CHANGE doc_id doc_id INT NOT NULL');
    }
}
