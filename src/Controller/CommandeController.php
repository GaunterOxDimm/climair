<?php

namespace App\Controller;

use App\Entity\Rdv;
use App\Entity\Commande;
use App\Entity\LigneDeCommande;
use App\Repository\RdvRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommandeRepository;
use App\Repository\PrestationRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LigneDeCommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/commande", name="commander_")
 */
class CommandeController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, SessionInterface $session, ArticleRepository $articleRepository, PrestationRepository $prestationRepository, LigneDeCommandeRepository $ligneDeCommandeRepository, CommandeRepository $commandeRepository, RdvRepository $rdvRepository, ManagerRegistry $doctrine): Response
    {
        $title = 'Climair - Commande';   // rendu du titre de la page

        $user = $this->getUser(); // On récupère l'objet Utilisateur connecté
        if ($user) {
            $email_utilisateur = $user->getUserIdentifier(); // L'utilisateur est connecté. On récupère ses identifiants email / username
            $nom_utilisateur = $user->getNomUtilisateur();
            $nom = $user->getNom();
            $prenom = $user->getPrenom();
            $adresse = $user->getAdresse();
        } else {
            return $this->redirectToRoute('app_login'); // L'utilisateur n'est pas connecté, redirection vers la page de connexion
        }

        $panier = $request->getSession()->get('panier', []); // récuperation du panier
        // initialisation des variables
        $total = 0;
        $article = null;
        $prestation = null;
        date_default_timezone_set('Europe/Paris');  // Définition du fuseau horaire
        $date_commande = new \DateTime();           // instance de la classe \DateTime
        $date_rdv = new \DateTime();
        $statut = '';

        // Récupérer les articles associés à chaque élément du panier
        $articles = [];
        foreach ($panier as $id => $quantite) {
            if ($id >= 100) {
                $article = $articleRepository->find($id);                 // on va chercher dans le tableau $panier 
                if ($article) {                                           // si le panier n'est pas vide
                    $article->setStock($article->getStock() - $quantite); // MàJ du stock
                    $articles[] = [                                       // on push dans le tableau $articles
                        'article' => $article,
                        'quantite' => $quantite
                    ];
                }
                $total += $article->getPrixArticle() * $quantite;         // calcul du prix total de la commande
            }
        }

        // Récupérer les prestations associés à chaque élément du panier
        $prestations = [];
        foreach ($panier as $id => $presta) {
            if ($id < 100) {
                $prestation = $prestationRepository->find($id); // on va chercher dans le tableau $panier 
                if ($prestation) {                              // si le panier n'est pas vide
                    $prestations[] = [                          // on push dans le tableau $prestations
                        'prestation' => $prestation,
                        'date_rdv' => $presta[0]['date_rdv'],
                        'statut' => $presta[0]['statut']
                    ];
                }
                $total += ($prestation->getPrixPrestation()); // calcul du prix total de la prestation
            }
        }

        $entityManager = $doctrine->getManager();   // on se connecte à la BDD

        $commande = new Commande();                 // instance de la classe Commande
        $commande->setDateCommande($date_commande); // on affecte à la commande la date actuelle
        $date_string = $date_commande->format('Y-m-d H:i:s'); // Mettre la date sous forme de string
        $commande->setUtilisateur($user);           // On attribue l'user connecté à la commande
        $commande->setTotalCommande($total);        // On attribue le total calculé à la commande

        foreach ($panier as $item => $key) {
            if ($item < 100) {
                $date_rdv_string = $key[0]['date_rdv'];
                $statut = $key[0]['statut'];
                $rdv = new Rdv();
                //setters
                $rdv->setDateRdv($date_rdv);
                $rdv->setStatut($statut);
                $rdv->setCommande($commande);
                $rdv->setPrestation($prestation);

                $entityManager->persist($rdv);
            }
        }

        // on fait persister les nouvelles données 
        //du panier en BDD dans la table commande
        $entityManager->persist($commande);

        $ligneDeCommande = new LigneDeCommande(); // Instance de la classe LigneDeCommande
        $ligneDeCommande->setCommande($commande); // On insert les clés étrangères dans la table LigneDeCommande

        if ($article) {
            $ligneDeCommande->setArticle($article); // ""
        }
        if ($prestation) {
            $ligneDeCommande->setPrestation($prestation); // ""
        }



        $entityManager->persist($ligneDeCommande); // on fait persister les données de clé étrangères en BDD dans la table LigneDeCommande
        $entityManager->flush(); // Synchronisation des changements en BDD
        $session->set('panier', []); // remise à zéro du panier
        return $this->render('commande/index.html.twig', compact(
            'title',
            'email_utilisateur',
            'nom_utilisateur',
            'nom',
            'prenom',
            'adresse',
            'articles',
            'prestations',
            'total',
            'date_string',
            'commande'
        )); // on utilise la méthode Compact() pour éviter de réécrire les clés => valeurs
    }
}
