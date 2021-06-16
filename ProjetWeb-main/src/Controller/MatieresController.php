<?php

namespace App\Controller;

use App\Entity\MatiereNiveauFiliere;
use App\Form\MatiereNiveauFiliereType;
use App\Repository\MatiereNiveauFiliereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/matieres')]
class MatieresController extends AbstractController
{
    #[Route('/', name: 'matieres_index', methods: ['GET'])]
    public function index(MatiereNiveauFiliereRepository $matiereNiveauFiliereRepository): Response
    {
        return $this->render('matieres/index.html.twig', [
            'matiere_niveau_filieres' => $matiereNiveauFiliereRepository->findAll(),
            'title' => 'Matières par classe'
        ]);
    }

    #[Route('/new', name: 'matieres_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $matiereNiveauFiliere = new MatiereNiveauFiliere();
        $form = $this->createForm(MatiereNiveauFiliereType::class, $matiereNiveauFiliere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($matiereNiveauFiliere);
            $entityManager->flush();

            $this->addFlash('success', "Matiére " . $matiereNiveauFiliere->getMatiere()->getNom()
            . " - " . $matiereNiveauFiliere->getFiliere()->getFiliere().$matiereNiveauFiliere->getNiveau()->getNiveau()
                . " est ajoutée avec succés ");

            return $this->redirectToRoute('matieres_index');
        }

        return $this->render('matieres/new.html.twig', [
            'matiere_niveau_filiere' => $matiereNiveauFiliere,
            'form' => $form->createView(),
            'title' => 'Ajouter une matière',
        ]);
    }

    #[Route('/{id}', name: 'matieres_show', methods: ['GET'])]
    public function show(MatiereNiveauFiliere $matiereNiveauFiliere): Response
    {
        return $this->render('matieres/show.html.twig', [
            'matiere_niveau_filiere' => $matiereNiveauFiliere,
            'title' => 'Matière : '. $matiereNiveauFiliere->getMatiere()->getNom(),
        ]);
    }

    #[Route('/{id}/edit', name: 'matieres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MatiereNiveauFiliere $matiereNiveauFiliere): Response
    {
        $form = $this->createForm(MatiereNiveauFiliereType::class, $matiereNiveauFiliere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Matiére " . $matiereNiveauFiliere->getMatiere()->getNom()
                . " - " . $matiereNiveauFiliere->getFiliere()->getFiliere().$matiereNiveauFiliere->getNiveau()->getNiveau()
                . " est modifiée avec succés ");

            return $this->redirectToRoute('matieres_index');
        }

        return $this->render('matieres/edit.html.twig', [
            'matiere_niveau_filiere' => $matiereNiveauFiliere,
            'form' => $form->createView(),
            'title' => 'Modifier une matière',
        ]);
    }

    #[Route('/{id}', name: 'matieres_delete', methods: ['POST'])]
    public function delete(Request $request, MatiereNiveauFiliere $matiereNiveauFiliere): Response
    {
        if ($this->isCsrfTokenValid('delete'.$matiereNiveauFiliere->getId(), $request->request->get('_token'))) {

            $this->addFlash('warning',"Matière : ". $matiereNiveauFiliere->getMatiere()->getNom()
                . " - " . $matiereNiveauFiliere->getFiliere()->getFiliere()
                . $matiereNiveauFiliere->getNiveau()->getNiveau() . " est supprimée" );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($matiereNiveauFiliere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('matieres_index');
    }
}
