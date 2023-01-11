<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique', name: 'app_boutique')]
    public function index(): Response
    {
        $title = 'Climair - Boutique';
        return $this->render('boutique/index.html.twig', [
            'controller_name' => 'BoutiqueController',
            'title' => $title
        ]);
    }
}