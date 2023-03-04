<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Repository\PrestationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/prestation", name="prestation_")
 */
class PrestationController extends AbstractController
{

    /**
     * @Route("/prestation/{id}", name="page", requirements={"id"="\d+"})
     */
    public function index(PrestationRepository $prestationRepository, Prestation $prestation): Response
    {

        // dd($prestations);
        $id_prestation = $prestation->getId();
        $prestationChoisie = $prestationRepository->find($id_prestation);
        $prestations = $prestationRepository->findAllExcept($prestation);

        // dd($prestationChoisie);

        $title = 'Climair - Prestation';
        return $this->render('prestation/index.html.twig', compact('prestationChoisie', 'prestations', 'title'));
    }
}
