<?php

namespace App\Controller;

use App\Repository\ImagesDiversRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(ImagesDiversRepository $contact): Response
    {
        $title = 'Climair - Contact';
        return $this->render('contact/index.html.twig', [
            'title' => $title,
        ]);
    }
}
