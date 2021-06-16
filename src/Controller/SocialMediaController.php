<?php

namespace App\Controller;

use App\Entity\SocialMedia;
use App\Form\SocialMediaType;
use App\Repository\SocialMediaRepository;
use App\Service\AppDataManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/social/media')]
class SocialMediaController extends AbstractController
{
    private $appDataManager;

    public function __construct(AppDataManager $appDataManager){
        $this->appDataManager = $appDataManager;
    }

    #[Route('/', name: 'social_media_index', methods: ['GET'])]
    public function index(SocialMediaRepository $socialMediaRepository): Response
    {
        return $this->render('social_media/index.html.twig', [
            'social_media' => $socialMediaRepository->findAll(),
            'title' => 'Réseaux sociaux',
        ]);
    }

    #[Route('/new', name: 'social_media_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $socialMedia = new SocialMedia();
        $form = $this->createForm(SocialMediaType::class, $socialMedia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($socialMedia);
            $entityManager->flush();
            $this->appDataManager->reloadData();

            $this->addFlash('success',"Réseau social : ".$socialMedia->getNom()." ajouté avec succès" );

            return $this->redirectToRoute('social_media_index');
        }

        return $this->render('social_media/new.html.twig', [
            'social_media' => $socialMedia,
            'form' => $form->createView(),
            'title' => 'Ajouter un réseau social',
        ]);
    }

    #[Route('/{id}', name: 'social_media_show', methods: ['GET'])]
    public function show(SocialMedia $socialMedia): Response
    {
        return $this->render('social_media/show.html.twig', [
            'social_media' => $socialMedia,
            'title' => 'Réseau social : ' . $socialMedia->getNom(),
        ]);
    }

    #[Route('/{id}/edit', name: 'social_media_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SocialMedia $socialMedia): Response
    {
        $form = $this->createForm(SocialMediaType::class, $socialMedia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->appDataManager->reloadData();
            $this->addFlash('success',"Réseau social : ".$socialMedia->getNom()." modifié avec succès" );

            return $this->redirectToRoute('social_media_index');
        }

        return $this->render('social_media/edit.html.twig', [
            'social_media' => $socialMedia,
            'form' => $form->createView(),
            'title' => 'Modifier un réseau social',
        ]);
    }

    #[Route('/{id}', name: 'social_media_delete', methods: ['POST'])]
    public function delete(Request $request, SocialMedia $socialMedia): Response
    {
        if ($this->isCsrfTokenValid('delete'.$socialMedia->getId(), $request->request->get('_token'))) {

            $this->addFlash('warning',"Réseau sociale : ". $socialMedia->getNom()." est supprimé" );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($socialMedia);
            $entityManager->flush();
            try
            {
                $this->appDataManager->reloadData();
            }catch (\Exception $exception){}
        }

        return $this->redirectToRoute('social_media_index');
    }
}
