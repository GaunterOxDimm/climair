<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'commander')]
    public function index(CommandeRepository $commandeRepository): Response
    {
        $title = 'Climair - Commande';
        $commande = $commandeRepository->findAll();
        return $this->render('commande/index.html.twig', [
            'title' => $title,
            'commande' => $commande
        ]);
    }
}
