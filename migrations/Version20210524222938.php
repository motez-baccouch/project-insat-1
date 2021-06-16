<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524222938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite (id INT AUTO_INCREMENT NOT NULL, doc_id INT NOT NULL, photo_id INT NOT NULL, titre VARCHAR(255) NOT NULL, date DATE NOT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_54928197895648BC (doc_id), UNIQUE INDEX UNIQ_549281977E9E4C8C (photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE download (id INT AUTO_INCREMENT NOT NULL, doc_id INT NOT NULL, titre VARCHAR(255) NOT NULL, ordre INT NOT NULL, UNIQUE INDEX UNIQ_781A8270895648BC (doc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emploi_du_temps (id INT AUTO_INCREMENT NOT NULL, doc_id INT NOT NULL, filiere_id INT NOT NULL, annee_scolaire INT NOT NULL, UNIQUE INDEX UNIQ_F86B32C1895648BC (doc_id), UNIQUE INDEX UNIQ_F86B32C1180AA129 (filiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignant (id INT NOT NULL, departement_id INT NOT NULL, INDEX IDX_81A72FA1CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT NOT NULL, filiere_id INT NOT NULL, niveau_id INT NOT NULL, num_inscription INT NOT NULL, INDEX IDX_717E22E3180AA129 (filiere_id), INDEX IDX_717E22E3B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche_notes1 (id INT AUTO_INCREMENT NOT NULL, doc_id INT NOT NULL, enseignant_id INT NOT NULL, nom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7B9B4CB3895648BC (doc_id), INDEX IDX_7B9B4CB3E455FCC0 (enseignant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filiere (id INT AUTO_INCREMENT NOT NULL, filiere VARCHAR(255) NOT NULL, ordre INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, ordre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_niveau_filiere (id INT AUTO_INCREMENT NOT NULL, matiere_id INT NOT NULL, filiere_id INT NOT NULL, niveau_id INT NOT NULL, semestre INT NOT NULL, coefficient DOUBLE PRECISION NOT NULL, ds TINYINT(1) NOT NULL, tp TINYINT(1) NOT NULL, examen TINYINT(1) NOT NULL, ordre INT NOT NULL, INDEX IDX_65EE9301F46CD258 (matiere_id), INDEX IDX_65EE9301180AA129 (filiere_id), INDEX IDX_65EE9301B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moyenne (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, annee_scolaire INT NOT NULL, sem1 DOUBLE PRECISION NOT NULL, sem2 DOUBLE PRECISION NOT NULL, annuelle DOUBLE PRECISION NOT NULL, sem1_valid TINYINT(1) NOT NULL, sem2_valid TINYINT(1) NOT NULL, INDEX IDX_F27AFF8FDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, niveau INT NOT NULL, ordre INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, matiere_id INT NOT NULL, etudiant_id INT NOT NULL, anne_scolaire INT NOT NULL, note_ds DOUBLE PRECISION NOT NULL, note_tp DOUBLE PRECISION NOT NULL, note_examen DOUBLE PRECISION NOT NULL, ds_valid TINYINT(1) NOT NULL, tp_valid TINYINT(1) NOT NULL, examen_valid TINYINT(1) NOT NULL, INDEX IDX_CFBDFA14F46CD258 (matiere_id), INDEX IDX_CFBDFA14DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operateur (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametres (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, fax VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, anne_scolaire_courante INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_media (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, css_class VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197895648BC FOREIGN KEY (doc_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_549281977E9E4C8C FOREIGN KEY (photo_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE download ADD CONSTRAINT FK_781A8270895648BC FOREIGN KEY (doc_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE emploi_du_temps ADD CONSTRAINT FK_F86B32C1895648BC FOREIGN KEY (doc_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE emploi_du_temps ADD CONSTRAINT FK_F86B32C1180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA1CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA1BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fiche_notes1 ADD CONSTRAINT FK_7B9B4CB3895648BC FOREIGN KEY (doc_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE fiche_notes1 ADD CONSTRAINT FK_7B9B4CB3E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE matiere_niveau_filiere ADD CONSTRAINT FK_65EE9301F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE matiere_niveau_filiere ADD CONSTRAINT FK_65EE9301180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE matiere_niveau_filiere ADD CONSTRAINT FK_65EE9301B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE moyenne ADD CONSTRAINT FK_F27AFF8FDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere_niveau_filiere (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE operateur ADD CONSTRAINT FK_B4B7F99DBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA1CCF9E01E');
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197895648BC');
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_549281977E9E4C8C');
        $this->addSql('ALTER TABLE download DROP FOREIGN KEY FK_781A8270895648BC');
        $this->addSql('ALTER TABLE emploi_du_temps DROP FOREIGN KEY FK_F86B32C1895648BC');
        $this->addSql('ALTER TABLE fiche_notes1 DROP FOREIGN KEY FK_7B9B4CB3895648BC');
        $this->addSql('ALTER TABLE fiche_notes1 DROP FOREIGN KEY FK_7B9B4CB3E455FCC0');
        $this->addSql('ALTER TABLE moyenne DROP FOREIGN KEY FK_F27AFF8FDDEAB1A3');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14DDEAB1A3');
        $this->addSql('ALTER TABLE emploi_du_temps DROP FOREIGN KEY FK_F86B32C1180AA129');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3180AA129');
        $this->addSql('ALTER TABLE matiere_niveau_filiere DROP FOREIGN KEY FK_65EE9301180AA129');
        $this->addSql('ALTER TABLE matiere_niveau_filiere DROP FOREIGN KEY FK_65EE9301F46CD258');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F46CD258');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3B3E9C81');
        $this->addSql('ALTER TABLE matiere_niveau_filiere DROP FOREIGN KEY FK_65EE9301B3E9C81');
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA1BF396750');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3BF396750');
        $this->addSql('ALTER TABLE operateur DROP FOREIGN KEY FK_B4B7F99DBF396750');
        $this->addSql('DROP TABLE actualite');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE download');
        $this->addSql('DROP TABLE emploi_du_temps');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE fiche_notes1');
        $this->addSql('DROP TABLE filiere');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE matiere_niveau_filiere');
        $this->addSql('DROP TABLE moyenne');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE operateur');
        $this->addSql('DROP TABLE parametres');
        $this->addSql('DROP TABLE social_media');
        $this->addSql('DROP TABLE user');
    }
}
