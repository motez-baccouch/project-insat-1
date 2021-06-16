<?php


namespace App\Service;


use App\Menu\Menu;
use App\Menu\MenuItem;
use App\Menu\MenuSection;
use Symfony\Component\Security\Core\Security;

class UserManager
{
    public const ROLE_USER = "ROLE_USER";
    public const ROLE_ENSEIGNANT = "ROLE_ENSEIGNANT";
    public const ROLE_ETUDIANT = "ROLE_ETUDIANT";
    public const ROLE_OPERATEUR = "ROLE_OPERATEUR";
    public const ROLE_ADMIN = "ROLE_ADMIN";
    public const ROLE_SCOLARITE = "ROLE_SCOLARITE";
    public const ROLE_VALIDATEUR = "ROLE_VALIDATEUR";
    public const ROLE_EDITEUR_SITE = "ROLE_EDITEUR_SITE";
    public const ROLE_EDITEUR_BASE = "ROLE_EDITEUR_BASE";

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    private function hasRole($role): bool
    {
        return $this->security->isGranted($role) ;
    }

    public function isAuthenticated(): bool
    {
        return $this->hasRole(self::ROLE_USER);
    }

    public function isEtudiant(): bool
    {
        return $this->hasRole(self::ROLE_ETUDIANT) ;
    }

    public function isEnseignant(): bool
    {
        return $this->hasRole(self::ROLE_ENSEIGNANT) ;
    }

    public function isOperateur(): bool
    {
        return $this->hasRole(self::ROLE_OPERATEUR) ;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(self::ROLE_ADMIN) ;
    }

    public function isScolarite(): bool
    {
        return $this->hasRole(self::ROLE_SCOLARITE) ;
    }

    public function isValidateur(): bool
    {
        return $this->hasRole(self::ROLE_VALIDATEUR) ;
    }

    public function isEditeurSite(): bool
    {
        return $this->hasRole(self::ROLE_EDITEUR_SITE) ;
    }

    public function isEditeurBase(): bool
    {
        return $this->hasRole(self::ROLE_EDITEUR_BASE) ;
    }

    public function getUserMenu(): Menu
    {
        $menuSections = array();

        if ($this->isAdmin())
        {
            $menuSection = new MenuSection("Administration");
            $menuSection->addMenuItem(new MenuItem("Les Operateurs", "users_index"));
            $menuSection->addMenuItem(new MenuItem("Creer un operateur", "operateur_new"));

            array_push($menuSections, $menuSection);
        }
        if($this->isEditeurBase())
        {
            $menuSection = new MenuSection("Données de base");
            $menuSection->addMenuItem(new MenuItem("Filières", "filiere_index"))
                ->addMenuItem(new MenuItem("Niveaux", "niveau_index"))
                ->addMenuItem(new MenuItem("Matiéres","matiere_index"))
                ->addMenuItem(new MenuItem("Départements", "departement_index"))
                ->addMenuItem(new MenuItem("Matiere par classe", "matieres_index"))
                ->addMenuItem(new MenuItem("Paramétres du site", "parametres_show"));

            array_push($menuSections, $menuSection);
        }
        if ($this->isEditeurSite())
        {
            $menuSection = new MenuSection("Contenu du site");
            $menuSection->addMenuItem(new MenuItem("Gestion des Actualités", "actualite_index"))
                ->addMenuItem(new MenuItem("Emplois du temps", "emploi_du_temps_index"))
                ->addMenuItem(new MenuItem("Téléchargements","download_index"))
                ->addMenuItem(new MenuItem("Liens", "link_index"))
                ->addMenuItem(new MenuItem("Réseaux sociaux","social_media_index"));

            array_push($menuSections, $menuSection);
        }
        if ($this->isValidateur())
        {
            $menuSection = new MenuSection("Validation");
            $menuSection->addMenuItem(new MenuItem("Valider notes", ""))
                ->addMenuItem(new MenuItem("Valider moyennes", ""))
                ->addMenuItem(new MenuItem("Scores", ""));
            array_push($menuSections, $menuSection);
        }
        if ($this->isScolarite())
        {
            $menuSection = new MenuSection("Scolarité");
            $menuSection->addMenuItem(new MenuItem("Saisie des notes", ""))
                ->addMenuItem(new MenuItem("Etudiants", ""))
                ->addMenuItem(new MenuItem("Enseignants",""))
                ->addMenuItem(new MenuItem("Fiches des notes","fiche_notes_index"));

            array_push($menuSections, $menuSection);

        }
        if ($this->isEtudiant())
        {
            $menuSection = new MenuSection("Espace étudiant");
            $menuSection->addMenuItem(new MenuItem("Notifications", ""))
                ->addMenuItem(new MenuItem("Notes", ""))
                ->addMenuItem(new MenuItem("Déliberations",""));

            array_push($menuSections, $menuSection);

        }
        if ($this->isEnseignant())
        {
            $menuSection = new MenuSection("Espace enseignant");
            $menuSection->addMenuItem(new MenuItem("Fiches des notes", "fiche_notes_index"));

            array_push($menuSections, $menuSection);
        }


        return new Menu($menuSections);
    }
}