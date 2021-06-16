<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/departement')]
class DepartementController extends AbstractController
{
    #[Route('/', name: 'departement_index', methods: ['GET'])]
    public function index(DepartementRepository $departementRepository): Response
    {
        return $this->render('departement/index.html.twig', [
            'departements' => $departementRepository->findAll(),
            'title' => 'Départements',
        ]);
    }

    #[Route('/new', name: 'departement_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $departement = new Departement();
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($departement);
            $entityManager->flush();

            $this->addFlash('success',"Département : ".$departement->getNom()." ajouté avec succès" );

            return $this->redirectToRoute('departement_index');
        }

        return $this->render('departement/new.html.twig', [
            'departement' => $departement,
            'form' => $form->createView(),
            'title' => 'Ajouter un département',
        ]);
    }

    #[Route('/{id}', name: 'departement_show', methods: ['GET'])]
    public function show(Departement $departement): Response
    {
        return $this->render('departement/show.html.twig', [
            'departement' => $departement,
            'title' => 'Département : ' . $departement->getNom(),
        ]);
    }

    #[Route('/{id}/edit', name: 'departement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Departement $departement): Response
    {
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success',"Département : ".$departement->getNom()." modifié avec succès" );

            return $this->redirectToRoute('departement_index');
        }

        return $this->render('departement/edit.html.twig', [
            'departement' => $departement,
            'form' => $form->createView(),
            'title' => 'Modifier un département',
        ]);
    }

    #[Route('/{id}', name: 'departement_delete', methods: ['POST'])]
    public function delete(Request $request, Departement $departement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$departement->getId(), $request->request->get('_token'))) {

            $this->addFlash('warning',"Département : ". $departement->getNom()." est supprimée" );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($departement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('departement_index');
    }
}
