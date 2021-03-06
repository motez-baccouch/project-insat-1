<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[IsGranted('ROLE_SCOLARITE', message: 'No access')]
#[Route('/etudiants')]
class EtudiantController extends AbstractController
{
    #[Route('/', name: 'etudiant_index', methods: ['GET'])]
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
            'title'=>"Etudiants"
        ]);
    }

    #[Route('/new', name: 'etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserManager $userManager, UserPasswordEncoderInterface $encoder ): Response
    {
        $etudiant = new Etudiant();
        $etudiant->setRoles([$userManager::ROLE_ETUDIANT]);
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $password=$form->get('password')->getData();
             $encoded=$encoder->encodePassword($etudiant,(string)$password);
             $etudiant->setPassword($encoded);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();

            $this->addFlash('success',"Etudiant : ".$etudiant->getNom(). " ".  $etudiant->getPrenom() ." ajouté avec succès" );


            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
            'title'=>"Ajouter un etudiant"
        ]);
    }

    #[Route('/{id}', name: 'etudiant_show', methods: ['GET'])]
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
            'title'=>'Etudiant : ' . $etudiant->getNom() . " " . $etudiant->getPrenom(),
        ]);
    }

    #[Route('/{id}/edit', name: 'etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etudiant $etudiant,UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password=$form->get('password')->getData();
            $encoded=$encoder->encodePassword($etudiant,(string)$password);
            $etudiant->setPassword($encoded);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success',"Etudiant : ".$etudiant->getNom(). " ".  $etudiant->getPrenom() ." modifié avec succès" );


            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
            'title'=>"Modifier un etudiant"
        ]);
    }

    #[Route('/{id}', name: 'etudiant_delete', methods: ['POST'])]
    public function delete(Request $request, Etudiant $etudiant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $this->addFlash('warning',"Etudiant : ".$etudiant->getNom(). " ".  $etudiant->getPrenom() ." suprimé avec succès" );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etudiant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etudiant_index');
    }
}
