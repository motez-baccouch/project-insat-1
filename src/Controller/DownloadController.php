<?php

namespace App\Controller;

use App\Entity\Download;
use App\Form\DownloadType;
use App\Repository\DownloadRepository;
use App\Service\FileUploader;
use App\Utilities\FormHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/download')]
class DownloadController extends AbstractController
{
    private $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    #[Route('/', name: 'download_index', methods: ['GET'])]
    public function index(DownloadRepository $downloadRepository): Response
    {
        return $this->render('download/index.html.twig', [
            'downloads' => $downloadRepository->findAll(),
            'title' => 'Téléchargements',
        ]);
    }

    #[Route('/new', name: 'download_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $download = new Download();
        $form = $this->createForm(DownloadType::class, $download);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUploads($form, $download);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($download);
            $entityManager->flush();

            $this->addFlash('success',"Téléchargement : ".$download->getTitre()." ajouté avec succès" );

            return $this->redirectToRoute('download_index');
        }

        return $this->render('download/new.html.twig', [
            'download' => $download,
            'form' => $form->createView(),
            'title' => 'Ajouter un téléchargement',
        ]);
    }

    #[Route('/{id}', name: 'download_show', methods: ['GET'])]
    public function show(Download $download): Response
    {
        return $this->render('download/show.html.twig', [
            'download' => $download,
            'title' => 'Téléchargement : '.$download->getTitre(),
        ]);
    }

    #[Route('/{id}/edit', name: 'download_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Download $download): Response
    {
        $form = $this->createForm(DownloadType::class, $download);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUploads($form, $download);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($download);
            $entityManager->flush();
            $this->addFlash('success',"Téléchargement : ".$download->getTitre()." modifié avec succès" );

            return $this->redirectToRoute('download_index');
        }

        return $this->render('download/edit.html.twig', [
            'download' => $download,
            'form' => $form->createView(),
            'title' => 'Modifier un téléchargement',
        ]);
    }

    #[Route('/{id}', name: 'download_delete', methods: ['POST'])]
    public function delete(Request $request, Download $download): Response
    {
        if ($this->isCsrfTokenValid('delete'.$download->getId(), $request->request->get('_token'))) {

            $this->addFlash('warning',"Téléchargement : ". $download->getTitre()." est supprimée" );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($download);
            $entityManager->flush();
        }

        return $this->redirectToRoute('download_index');
    }


    private function handleUploads($form, $download){
        $document = FormHelper::handleUpload($form, 'document', $download->getDoc(), $this->fileUploader);

        if($document)
            $download->setDoc($document);
    }
}
