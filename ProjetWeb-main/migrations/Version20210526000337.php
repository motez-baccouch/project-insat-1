<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210526000337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE filiere_niveau (filiere_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_7413A5F4180AA129 (filiere_id), INDEX IDX_7413A5F4B3E9C81 (niveau_id), PRIMARY KEY(filiere_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE filiere_niveau ADD CONSTRAINT FK_7413A5F4180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE filiere_niveau ADD CONSTRAINT FK_7413A5F4B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE filiere_niveau');
    }
}
