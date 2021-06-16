<?php

namespace App\Controller;

use App\Entity\FicheNotes;
use App\Form\FicheNotesType;
use App\Repository\FicheNotesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fiche/notes')]
class FicheNotesController extends AbstractController
{
    #[Route('/', name: 'fiche_notes_index', methods: ['GET'])]
    public function index(FicheNotesRepository $ficheNotesRepository): Response
    {
        return $this->render('fiche_notes/index.html.twig', [
            'fiche_notes' => $ficheNotesRepository->findAll(),
            'title' => 'Fiches des notes',
        ]);
    }

    #[Route('/new', name: 'fiche_notes_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $ficheNote = new FicheNotes();
        $form = $this->createForm(FicheNotesType::class, $ficheNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ficheNote->setEnseignant($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ficheNote);
            $entityManager->flush();

            return $this->redirectToRoute('enseignant_fiches');
        }

        return $this->render('fiche_notes/new.html.twig', [
            'fiche_note' => $ficheNote,
            'form' => $form->createView(),
            'title' => 'Ajouter une Fiche des notes',
        ]);
    }

    #[Route('/{id}', name: 'fiche_notes_show', methods: ['GET'])]
    public function show(FicheNotes $ficheNote): Response
    {
        $matiere = $ficheNote->getMatiere();
        return $this->render('fiche_notes/show.html.twig', [
            'fiche_note' => $ficheNote,
            'title' => 'Fiche des notes : '.$matiere->getNiveau()->getNiveauName2($matiere->getFiliere()),
        ]);
    }

    #[Route('/{id}/edit', name: 'fiche_notes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FicheNotes $ficheNote): Response
    {
        $form = $this->createForm(FicheNotesType::class, $ficheNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('enseignant_fiches');
        }

        return $this->render('fiche_notes/edit.html.twig', [
            'fiche_note' => $ficheNote,
            'form' => $form->createView(),
            'title' => 'Modifier la fiche des notes',
        ]);
    }

    #[Route('/{id}', name: 'fiche_notes_delete', methods: ['POST'])]
    public function delete(Request $request, FicheNotes $ficheNote): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ficheNote->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ficheNote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fiche_notes_index');
    }
}
