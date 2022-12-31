<?php

namespace App\Controller;

use App\Repository\ImagesDiversRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/clim/accueil', name: 'app_accueil', methods: ['GET'])]
    public function index(ImagesDiversRepository $repository): Response
    {
        $telecommande = $repository->findOneBy(['id' => 1]);
        $clim_blanche = $repository->findOneBy(['id' => 2]);
        $clim_rouge = $repository->findOneBy(['id' => 3]);
        $snow = $repository->findOneBy(['id' => 4]);
        // dd($imagesaccueil);
        return $this->render('accueil/index.html.twig', [
            'telecommande' => $telecommande,
            'clim_blanche' => $clim_blanche,
            'clim_rouge' => $clim_rouge,
            'snow' => $snow,
        ]);
    }
}
