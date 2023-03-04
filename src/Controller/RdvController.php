<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Entity\Rdv;
use App\Form\RendezVousType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RdvController extends AbstractController
{
    #[Route('/rdv', name: 'app_rdv')]
    public function index(): Response
    {
        return $this->render('rdv/index.html.twig', [
            'controller_name' => 'RdvController',
        ]);
    }

    /**
     * @Route("/prendre-rendez-vous/{id}", name="prendre_rendez_vous")
     */
    public function prendreRendezVous(Request $request, int $id, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $prestation = $entityManager->getRepository(Prestation::class)->find($id); // Récuperation de la prestation grâce à son id

        $rdv = new Rdv(); // Nouvelle instance de l'objet Rdv

        $form = $this->createForm(RendezVousType::class, $rdv); // Création d'un formulaire RendezVousType
        $form->handleRequest($request); // Traitement de la soumission du formulaire

        $rdv->setPrestation($prestation); // on insére l'objet $prestation dans l'objet $rdv

        if ($form->isSubmitted() && $form->isValid()) {
            $rdv = $form->getData(); // on récupère les données du formulaire

            // on récupere le panier
            $panier = $session->get('panier', []);

            // On vérifie si la prestation est déjà dans le panier
            $prestationId = $prestation->getId();
            if (array_key_exists($prestationId, $panier)) {
                // Si oui, on ajoute le rendez-vous au tableau des rendez-vous existant
                $panier[$prestationId][] = [
                    'date_rdv' => $rdv->getDateRdv()->format('Y-m-d H:i'),
                    'statut' => $rdv->getStatut(),
                ];
            } else {
                // Sinon, on ajoute la prestation et le rendez-vous dans le panier
                $panier[$prestationId] = [
                    [
                        'date_rdv' => $rdv->getDateRdv()->format('Y-m-d H:i'),
                        'statut' => $rdv->getStatut(),
                    ]
                ];
            }
            $session->set('panier', $panier);
            // dd($panier);
            // // Enregistrer la prestation en base de données

            // $entityManager->persist($rdv);
            // $entityManager->flush();

            return $this->redirectToRoute('cart_add_prestation', [
                'id' => $prestation->getId(),
                'date' => $rdv->getDateRdv()->format('Y-m-d H:i'),
                'statut' => $rdv->getStatut()
            ]);
        }

        return $this->render('rdv/index.html.twig', [
            'form' => $form->createView(),
            'prestation' => $prestation,
        ]);
    }
}
