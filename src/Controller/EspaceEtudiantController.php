<?php

namespace App\Controller;

use App\Entity\HistorySelection;
use App\Entity\MatiereNiveauFiliere;
use App\Entity\MatiereSelection;
use App\Entity\Moyenne;
use App\Entity\Note;
use App\Form\HistorySelectionType;
use App\Form\MatiereSelectionType;
use App\Service\AppDataManager;
use App\Utilities\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etudiant')]
class EspaceEtudiantController extends AbstractController
{

    private $appDataManager;
    private $manager;

    public function __construct(EntityManagerInterface $manager, AppDataManager $appDataManager)
    {
        $this->appDataManager = $appDataManager;
        $this->manager = $manager;
    }

    #[Route('/releve', name: 'etudiant_releve')]
    public function releve(): Response
    {
        $annee = $this->appDataManager->getParametres()->getAnneScolaireCourante();
        $noteRepository = $this->manager->getRepository(MatiereNiveauFiliere::class);
        $semestre1 = $noteRepository->getReleve($this->getUser(), $annee, 1);
        $semestre2 = $noteRepository->getReleve($this->getUser(), $annee, 2);

        $moyenneRepository = $this->manager->getRepository(Moyenne::class);
        $moyenne = $moyenneRepository->findOneBy(['etudiant'=>$this->getUser(), 'anneeScolaire'=>$annee]);

        return $this->render('espace_etudiant/releve.html.twig', [
            'title' => 'Relevé de notes : ' . Tools::getAnneeScolaireFormatted($annee),
            'semestre1'=> $semestre1,
            'semestre2'=> $semestre2,
            'moyenne' => $moyenne,
            'addButtons'=> true,
        ]);

    }



    #[Route('/historique/{annee?0}', name: 'etudiant_historique')]
    public function historique(Request $request, $annee): Response
    {
        $historySelection = new HistorySelection($this->getUser(), $annee, $this->appDataManager);
        $form = $this->createForm(HistorySelectionType::class, $historySelection);
        $form->handleRequest($request);

        $noteRepository = $this->manager->getRepository(Note::class);
        $semestre1 = $noteRepository->getHistorique($historySelection, 1);
        $semestre2 = $noteRepository->getHistorique($historySelection, 2);

        return $this->render('espace_etudiant/history.html.twig', [
            'title' => 'Historique',
            'form'=> $form->createView(),
            'semestre1'=> $semestre1,
            'semestre2'=> $semestre2,
        ]);
    }

    #[Route('/notes/{matiere?0}', name: 'etudiant_notes')]
    public function notes(Request $request, $matiere): Response
    {
        $matiereSelection = new MatiereSelection($this->getUser(),
            $matiere, $this->appDataManager->getParametres()->getAnneScolaireCourante());
        $form = $this->createForm(MatiereSelectionType::class, $matiereSelection);
        $form->handleRequest($request);

        $noteRepository = $this->manager->getRepository(Note::class);
        $notes = $noteRepository->getNotes($matiereSelection);

        return $this->render('espace_etudiant/matiere.html.twig', [
            'title' => 'Notes : '.Tools::getAnneeScolaireFormatted($matiereSelection->getAnnee()),
            'form'=> $form->createView(),
            'notes'=> $notes,
            'etudiant' => $matiereSelection->getTmpEtudiant(),
        ]);
    }
}
