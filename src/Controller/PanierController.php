<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/panier', name: 'panier_')]

class PanierController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $title = 'Climair - Panier';
        return $this->render('panier/index.html.twig', [
            'title' => $title,
        ]);
    }

    #[Route('/add/{id}', name: 'add')]

    public function add($id, SessionInterface $session): Response
    {

        dd($session);
    }
}
