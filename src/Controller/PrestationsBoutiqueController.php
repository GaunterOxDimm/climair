<?php

namespace App\Controller;


use App\Repository\PrestationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PrestationsBoutiqueController extends AbstractController
{
    #[Route('/prestations', name: 'prestations')]
    public function index(PrestationRepository $prestationRepository, SessionInterface $session): Response
    {
        $prestations = $prestationRepository->findAll();
        $panier = $session->get('panier', []);
        $title = 'Climair - Prestation';
        return $this->render('prestations_boutique/index.html.twig', compact('prestations', 'title', 'panier'));
    }
}
