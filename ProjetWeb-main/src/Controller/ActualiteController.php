<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Repository\ActualiteRepository;
use App\Service\FileUploader;
use App\Utilities\FormHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/actualite')]
class ActualiteController extends AbstractController
{
    private $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    #[Route('/', name: 'actualite_index', methods: ['GET'])]
    public function index(ActualiteRepository $actualiteRepository): Response
    {
        return $this->render('actualite/index.html.twig', [
            'actualites' => $actualiteRepository->findAll(),
            'title' => 'Actualités',

        ]);
    }

    #[Route('/new', name: 'actualite_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUploads($form, $actualite);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actualite);
            $entityManager->flush();

            return $this->redirectToRoute('actualite_index');
        }

        return $this->render('actualite/new.html.twig', [
            'actualite' => $actualite,
            'form' => $form->createView(),
            'title' => 'Ajouter une actualité',
        ]);
    }

    #[Route('/{id}', name: 'actualite_show', methods: ['GET'])]
    public function show(Actualite $actualite): Response
    {
        return $this->render('actualite/show.html.twig', [
            'actualite' => $actualite,
            'title' => 'Actualité : '.$actualite->getTitre(),
        ]);
    }

    #[Route('/{id}/edit', name: 'actualite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actualite $actualite): Response
    {
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUploads($form, $actualite);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actualite);
            $entityManager->flush();

            return $this->redirectToRoute('actualite_index');
        }

        return $this->render('actualite/edit.html.twig', [
            'actualite' => $actualite,
            'form' => $form->createView(),
            'title' => 'Modifier une actualité',
        ]);
    }

    #[Route('/{id}', name: 'actualite_delete', methods: ['POST'])]
    public function delete(Request $request, Actualite $actualite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actualite);
            $entityManager->flush();

            $this->addFlash('warning',"votre actualité est supprimée" );
        }

        return $this->redirectToRoute('actualite_index');
    }

    private function handleUploads($form, $actualite){
        $photo = FormHelper::handleUpload($form, 'image', $actualite->getPhoto(), $this->fileUploader);
        $document = FormHelper::handleUpload($form, 'document', $actualite->getDoc(), $this->fileUploader);

        if($photo)
            $actualite->setPhoto($photo);
        if($document)
            $actualite->setDoc($document);
    }
}
