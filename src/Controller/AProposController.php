<?php

namespace App\Controller;

use App\Repository\ImagesDiversRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\AccueilController;

class AProposController extends AbstractController
{
    #[Route('/a-propos', name: 'app_a_propos', methods: ['GET'])]
    public function index(ImagesDiversRepository $flambard): Response
    {
        $a_propos = $flambard->findOneBy(['id' => 6]);
        return $this->render('a_propos/index.html.twig', [
            'a-propos' => $a_propos,
        ]);
    }
}
