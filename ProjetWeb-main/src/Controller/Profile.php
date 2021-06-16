<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilePhotoType;
use App\Service\FileUploader;
use App\Utilities\FormHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Profile extends AbstractController
{
    private $fileUploader;
    private $manager;

    public function __construct(FileUploader $fileUploader, EntityManagerInterface $manager)
    {
        $this->fileUploader = $fileUploader;
        $this->manager = $manager;
    }

    /**
     * @Route ("/profile", name="profil")
     */
    public function profile(Request $request): Response
    {
        $user = $this->manager->getRepository(User::class)->find($this->getUser()->getId());
        $form = $this->createForm(ProfilePhotoType::class, $user);
        $form->handleRequest($request);

        return $this->render('profile.html.twig', [
            'title' => 'Profil : '. $user->getNom() . " " . $user->getPrenom(),
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update-photo", name="updateProfilePhoto")
     */
    public function updatePhoto(Request $request):Response{
        $user = $this->manager->getRepository(User::class)->find($this->getUser()->getId());
        $form = $this->createForm(ProfilePhotoType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleUploads($form, $user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return new Response("/" . $user->getPhoto()->getFullUrl());
        }
    }

    private function handleUploads($form, $user){
        $photo = FormHelper::handleUpload($form, 'image', $user->getPhoto(), $this->fileUploader);

        if($user)
            $user->setPhoto($photo);
    }

}
