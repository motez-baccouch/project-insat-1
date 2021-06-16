<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotFoundController extends AbstractController
{
    #[Route('/404', name: 'not_found')]
    public function index(): Response
    {
        return $this->render('404.html.twig', [
            'title' => '404_not_found',
        ]);
    }
}
