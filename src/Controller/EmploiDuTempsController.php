<?php

namespace App\Controller;

use App\Entity\EmploiDuTemps;
use App\Form\EmploiDuTempsType;
use App\Repository\EmploiDuTempsRepository;
use App\Service\FileUploader;
use App\Utilities\FormHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/emploi/du/temps')]
class EmploiDuTempsController extends AbstractController
{

    private $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    #[Route('/', name: 'emploi_du_temps_index', methods: ['GET'])]
    public function index(EmploiDuTempsRepository $emploiDuTempsRepository): Response
    {
        return $this->render('emploi_du_temps/index.html.twig', [
            'emploi_du_temps' => $emploiDuTempsRepository->findAll(),
            'title' => 'Emplois du temps',
        ]);
    }

    #[Route('/new', name: 'emploi_du_temps_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $emploiDuTemp = new EmploiDuTemps();
        $form = $this->createForm(EmploiDuTempsType::class, $emploiDuTemp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUploads($form, $emploiDuTemp);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emploiDuTemp);
            $entityManager->flush();

            $this->addFlash('success',"Emploi du temps : ".$emploiDuTemp->getFiliere()->getFiliere()." ajouté avec succès" );

            return $this->redirectToRoute('emploi_du_temps_index');
        }

        return $this->render('emploi_du_temps/new.html.twig', [
            'emploi_du_temp' => $emploiDuTemp,
            'form' => $form->createView(),
            'title' => 'Ajouter un emploi du temps',
        ]);
    }

    #[Route('/{id}', name: 'emploi_du_temps_show', methods: ['GET'])]
    public function show(EmploiDuTemps $emploiDuTemp): Response
    {
        return $this->render('emploi_du_temps/show.html.twig', [
            'emploi_du_temp' => $emploiDuTemp,
            'title' => 'Emploi du temps : '.$emploiDuTemp->getFiliere()->getFiliere(),
        ]);
    }

    #[Route('/{id}/edit', name: 'emploi_du_temps_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EmploiDuTemps $emploiDuTemp): Response
    {
        $form = $this->createForm(EmploiDuTempsType::class, $emploiDuTemp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->handleUploads($form, $emploiDuTemp);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emploiDuTemp);
            $entityManager->flush();

            $this->addFlash('success',"Emploi du temps : ".$emploiDuTemp->getFiliere()->getFiliere()." modifié avec succès" );

            return $this->redirectToRoute('emploi_du_temps_index');
        }

        return $this->render('emploi_du_temps/edit.html.twig', [
            'emploi_du_temp' => $emploiDuTemp,
            'form' => $form->createView(),
            'title' => 'Modifier un emploi du temps',
        ]);
    }

    #[Route('/{id}', name: 'emploi_du_temps_delete', methods: ['POST'])]
    public function delete(Request $request, EmploiDuTemps $emploiDuTemp): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emploiDuTemp->getId(), $request->request->get('_token'))) {

            $this->addFlash('warning',"Emploi : ". $emploiDuTemp->getFiliere()->getFiliere()
                . " semestre " . $emploiDuTemp->getSemestre()." est supprimé" );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emploiDuTemp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('emploi_du_temps_index');
    }

    private function handleUploads($form, $emploiDuTemp){
        $document = FormHelper::handleUpload($form, 'document', $emploiDuTemp->getDoc(), $this->fileUploader);

        if($document)
            $emploiDuTemp->setDoc($document);
    }
}
