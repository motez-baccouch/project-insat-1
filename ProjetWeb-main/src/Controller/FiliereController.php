<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Form\FiliereType;
use App\Repository\FiliereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/filiere')]
class FiliereController extends AbstractController
{
    #[Route('/', name: 'filiere_index', methods: ['GET'])]
    public function index(FiliereRepository $filiereRepository): Response
    {
        return $this->render('filiere/index.html.twig', [
            'filieres' => $filiereRepository->findAll(),
            'title' => 'Filières',
        ]);
    }

    #[Route('/new', name: 'filiere_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $filiere = new Filiere();
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($filiere);
            $entityManager->flush();

            $this->addFlash('success',"Filiére : ".$filiere->getFiliere()." ajouté avec succès" );

            return $this->redirectToRoute('filiere_index');
        }

        return $this->render('filiere/new.html.twig', [
            'filiere' => $filiere,
            'form' => $form->createView(),
            'title' => 'Ajouter une filière',
        ]);
    }

    #[Route('/{id}', name: 'filiere_show', methods: ['GET'])]
    public function show(Filiere $filiere): Response
    {
        return $this->render('filiere/show.html.twig', [
            'filiere' => $filiere,
            'title' => 'Filière : '.$filiere->getFiliere(),
        ]);
    }

    #[Route('/{id}/edit', name: 'filiere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Filiere $filiere): Response
    {
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success',"Filiére : ".$filiere->getFiliere()." modifié avec succès" );

            return $this->redirectToRoute('filiere_index');
        }

        return $this->render('filiere/edit.html.twig', [
            'filiere' => $filiere,
            'form' => $form->createView(),
            'title' => 'Modifier une filière',
        ]);
    }

    #[Route('/{id}', name: 'filiere_delete', methods: ['POST'])]
    public function delete(Request $request, Filiere $filiere): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filiere->getId(), $request->request->get('_token'))) {

            $this->addFlash('warning',"Filière : ". $filiere->getFiliere()." est supprimée" );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($filiere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('filiere_index');
    }
}
