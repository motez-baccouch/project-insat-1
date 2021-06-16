<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Filiere;
use App\Entity\Matiere;
use App\Entity\MatiereNiveauFiliere;
use App\Entity\Niveau;
use App\Entity\Note;
use App\Service\AppDataManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScolariteController extends AbstractController
{

    private $manager;
    private $currentAnnee;

    public function __construct(EntityManagerInterface $manager, AppDataManager $appDataManager)
    {
        $this->manager = $manager;
        $this->currentAnnee = $appDataManager->getParametres()->getAnneScolaireCourante();
    }

    #[Route('/scolarite', name: 'scolarite')]
    public function index(Request $request): Response
    {
        $filiere = $this->manager->getRepository(Filiere::class)->findAll();

        $filieres = array();
        foreach ($filiere as $fil) {
            $niveau = $fil->getNiveaux();
            $fila = $fil->getFiliere();
            $filieres[$fila] = array();
            foreach ($niveau as $niv) {
                array_push($filieres[$fila], $niv->getNiveau());
            }
        }

        return $this->render('scolarite/index.html.twig', [
            'controller_name' => 'ScolariteController',
            'filieres' => $filieres,
            'title' => 'Saisie des notes',

        ]);
    }


    #[Route('/scolarite/{semester}/{filiere}/{niveau}/{matiere}/{type}', name: 'notes')]
    public function notes(Request $request, int $semester, string $filiere,
                          int $niveau, string $type, string $matiere): Response
    {

        $fil = $this->manager->getRepository(Filiere::class)->findOneBy(['filiere' => $filiere]);
        $niv = $this->manager->getRepository(Niveau::class)->findOneBy(['niveau' => $niveau]);
        $mat = $this->manager->getRepository(Matiere::class)->findOneBy(['nom' => $matiere]);

        $inTitle = $niv->getNiveauName2($fil) . ', Sem' . $semester . ', ' . $mat->getNom() . ', ' . $type;


        if (!$mat || !$fil || !$niv
            || ($semester != 1 && $semester != 2)
            || (strtoupper($type) != "DS" && strtoupper($type) != "TP" && strtoupper($type) != "EXAMEN")) {
            return $this->redirectToRoute('not_found');
        }

        $etudiants = $this->manager->getRepository(Etudiant::class)->findBy(['filiere' => $fil, 'niveau' => $niv]);
        $matNivFil = $this->manager->getRepository(MatiereNiveauFiliere::class)
            ->findOneBy(['matiere' => $mat, 'filiere' => $fil, 'niveau' => $niv, 'semestre' => $semester]);

        $hasType = false;
        if (strtoupper($type) == "DS") {
            $hasType = $matNivFil->getDs();
        } elseif (strtoupper($type)== "TP") {
            $hasType = $matNivFil->getTp();
        } elseif (strtoupper($type) == "EXAMEN") {
            $hasType = $matNivFil->getExamen();
        }
        if (!$hasType) {
            return $this->redirectToRoute('not_found');
        }

        $savedNotes = $this->manager->getRepository(Note::class)->findByMatiere($matNivFil, $this->currentAnnee);

        $TmpNotes = array();
        $savedNotes2 = array();
        $mark = null;
        foreach ($savedNotes as $note) {
            if (strtoupper($type) == "DS") {
                $mark = $note->getNoteDS();
            } elseif (strtoupper($type)== "TP") {
                $mark = $note->getNoteTp();
            } elseif (strtoupper($type) == "EXAMEN") {
                $mark = $note->getNoteExamen();
            }
            if (!empty($mark)) {
                $TmpNotes[$note->getEtudiant()->getId()] = $mark;
            }
            $savedNotes2[$note->getEtudiant()->getId()] = $note;
        }

        $notes = array();

        foreach ($etudiants as $etudiant) {
            $note = new Note();
            $note->setAnneScolaire($this->currentAnnee);
            $note->setEtudiant($etudiant);
            $note->setMatiere($matNivFil);
            $note->setTpValid(0);
            $note->setDsValid(0);
            $note->setExamenValid(0);
            if (array_key_exists($etudiant->getId(), $TmpNotes))
                $note->setTmpNote($TmpNotes[$etudiant->getId()]);

            array_push($notes, $note);
        }

        $changed = false;
        if ($request->isMethod('post')) {
            $posts = $request->request->all();
            unset($posts["DataTables_Table_0_length"]);

            $entityManager = $this->getDoctrine()->getManager();

            foreach ($notes as $note) {
                $idEtudiant = $note->getEtudiant()->getId();

                $post = array_key_exists($idEtudiant, $posts) ? $posts[$idEtudiant] : "";
                $post = !empty(trim($post)) ? floatval($post) : null;

                $savedNoteExists = array_key_exists($idEtudiant, $savedNotes2);
                $cNote =  $savedNoteExists ? $savedNotes2[$idEtudiant] : $note;
                if (strtoupper($type)== "DS") {
                    $cNote->setNoteDS($post);
                } elseif (strtoupper($type) == "TP") {
                    $cNote->setNoteTp($post);
                } elseif (strtoupper($type) == "EXAMEN") {
                    $cNote->setNoteExamen($post);
                }

                if (!$savedNoteExists)
                    $entityManager->persist($cNote);
                $changed = true;
            }

            if ($changed)
                $entityManager->flush();
            $this->addFlash('success', "Notes : " . $inTitle . " ajoutées avec succès");
            return $this->redirectToRoute('matiere', [
                'semester' => $semester,
                'filiere' => $filiere,
                'niveau' => $niveau,
            ]);
        }
        return $this->render('scolarite/notes.html.twig', [
            'notes' => $notes,
            'title' => 'Saisie des notes : ' . $inTitle,
        ]);

    }


    #[Route('/scolarite/{semester}/{filiere}/{niveau}', name: 'matiere')]
    public function mats(Request $request, int $semester, string $filiere, int $niveau): Response
    {
        $fil = $this->manager->getRepository(Filiere::class)->findOneBy(['filiere' => $filiere]);

        $niv = $this->manager->getRepository(Niveau::class)->findOneBy(['niveau' => $niveau]);

        $matieres = $this->manager->getRepository(MatiereNiveauFiliere::class)
            ->findBy(['filiere' => $fil, 'niveau' => $niv, 'semestre' => $semester]);

        $matiere = array();

        foreach ($matieres as $mat) {
            $matName = $mat->getMatiere()->getNom();

            $matiere[$matName] = array();
            if ($mat->getDs()) {
                array_push($matiere[$matName], "DS");
            }
            if ($mat->getTp()) {
                array_push($matiere[$matName], "TP");
            }
            if ($mat->getExamen()) {
                array_push($matiere[$matName], "EXAMEN");
            }

        }

        return $this->render('scolarite/matieres.html.twig', [
            'controller_name' => 'ScolariteController',
            'matiere' => $matiere,
            'title' => 'Saisie des notes : ' . $niv->getNiveauName2($fil) . ', ' . 'Sem ' . $semester,
            'semester' => $semester,
            'filiere' => $filiere,
            'niveau' => $niveau
        ]);
    }

}
