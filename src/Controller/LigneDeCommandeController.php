<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LigneDeCommandeController extends AbstractController
{
    #[Route('/ligne/de/commande', name: 'app_ligne_de_commande')]
    public function index(): Response
    {

        return $this->render('ligne_de_commande/index.html.twig', [
            'controller_name' => 'LigneDeCommandeController',
        ]);
    }
}
