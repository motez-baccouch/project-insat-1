<?php

namespace App\Controller;

use App\Entity\Link;
use App\Form\LinkType;
use App\Repository\LinkRepository;
use App\Service\AppDataManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/link')]
class LinkController extends AbstractController
{
    private $appDataManager;

    public function __consruct(AppDataManager $appDataManager)
    {
        $this->appDataManager = $appDataManager;
    }

    #[Route('/', name: 'link_index', methods: ['GET'])]
    public function index(LinkRepository $linkRepository): Response
    {
        return $this->render('link/index.html.twig', [
            'links' => $linkRepository->findAll(),
            'title' => 'Liens',
        ]);
    }

    #[Route('/new', name: 'link_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $link = new Link();
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($link);
            $entityManager->flush();
            if($this->appDataManager)
                $this->appDataManager->reloadData();

            $this->addFlash('success',"Lien : ".$link->getNom()." ajouté avec succès" );

            return $this->redirectToRoute('link_index');
        }

        return $this->render('link/new.html.twig', [
            'link' => $link,
            'form' => $form->createView(),
            'title' => 'Ajouter un lien',

        ]);
    }

    #[Route('/{id}', name: 'link_show', methods: ['GET'])]
    public function show(Link $link): Response
    {
        return $this->render('link/show.html.twig', [
            'link' => $link,
            'title' => 'Lien : '. $link->getNom(),
        ]);
    }

    #[Route('/{id}/edit', name: 'link_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Link $link): Response
    {
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            if($this->appDataManager)
                $this->appDataManager->reloadData();


            $this->addFlash('success',"Lien : ".$link->getNom()." modifié avec succès" );

            return $this->redirectToRoute('link_index');
        }

        return $this->render('link/edit.html.twig', [
            'link' => $link,
            'form' => $form->createView(),
            'title' => 'Modifier un lien',
        ]);
    }

    #[Route('/{id}', name: 'link_delete', methods: ['POST'])]
    public function delete(Request $request, Link $link): Response
    {
        if ($this->isCsrfTokenValid('delete'.$link->getId(), $request->request->get('_token'))) {

            $this->addFlash('warning',"Lien : ". $link->getNom()." est supprimé" );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($link);
            $entityManager->flush();
            if($this->appDataManager)
                $this->appDataManager->reloadData();
        }

        return $this->redirectToRoute('link_index');
    }
}
