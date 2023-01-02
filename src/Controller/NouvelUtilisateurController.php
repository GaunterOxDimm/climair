<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NouvelUtilisateurController extends AbstractController
{
    #[Route('/nouvel/utilisateur', name: 'app_nouvel_utilisateur')]
    public function index(): Response
    {
        return $this->render('nouvel_utilisateur/index.html.twig', [
            'controller_name' => 'NouvelUtilisateurController',
        ]);
    }
}
