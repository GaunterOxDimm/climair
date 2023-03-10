<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Prestation;
use App\Repository\ArticleRepository;
use App\Repository\PrestationRepository;
use App\Repository\RdvRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{

    /**
     * @Route("/", name="index")]
     */
    public function index(SessionInterface $session, ArticleRepository $articleRepository, PrestationRepository $prestationRepository, RdvRepository $rdvRepository): Response
    {
        $dataPanierArticle = [];
        $dataPanierPrestation = [];
        $dataPanierRendezVous = [];
        $total = 0;
        $panier = $session->get('panier', []);
        // dd($panier);

        $dataPanierArticle = $this->getDataPanierArticle($panier, $articleRepository);
        $dataPanierPrestation = $this->getDataPanierPrestation($panier, $prestationRepository, $rdvRepository);
        $dataPanierRendezVous = $this->getDataPanierRendezVous($panier);

        // dd($dataPanierArticle);

        $total = ($this->getTotal($dataPanierArticle, $dataPanierPrestation));

        $itemCount = count($dataPanierArticle) + count($dataPanierPrestation);
        // Stocker le nombre d'articles dans la session
        $session->set('cart_item_count', $itemCount);

        return $this->render('cart/index.html.twig', compact('dataPanierArticle', 'dataPanierPrestation', 'dataPanierRendezVous', 'total', 'itemCount'));
    }

    private function getDataPanierArticle($panier, $articleRepository)
    {
        $dataPanierArticle = [];
        foreach ($panier as $id => $quantite) {

            $article = $articleRepository->find($id);
            if ($article) {
                $dataPanierArticle[] = [
                    'article' => $article,
                    'quantite' => $quantite
                ];
            }
        }

        return $dataPanierArticle;
    }


    private function getDataPanierPrestation($panier, $prestationRepository)
    {
        $dataPanierPrestation = [];
        foreach ($panier as $id => $presta) {
            if ($id < 100) {
                $prestation = $prestationRepository->find($id);
                if ($prestation) {
                    $dataPanierPrestation[] = [
                        'prestation' => $prestation,
                        'date_rdv' => $presta[0]['date_rdv'],
                        'statut' => $presta[0]['statut']
                    ];
                }
            }
        }
        return $dataPanierPrestation;
    }


    public function getDataPanierRendezVous($panier)
    {
        $dataPanierRendezVous = [];
        // dd($panier);
        // Parcours du panier
        foreach ($panier as $rdvData) {
            // R??cup??ration des donn??es du rendez-vous
            if (isset($rdvData['date_rdv'])) {

                $dateRdv = $rdvData['date_rdv'];
                $statut = $rdvData['statut'];
                $prestation = $rdvData['prestation'];

                // Cr??ation d'un tableau associatif avec les donn??es du rendez-vous


                // Ajout du rendez-vous au tableau $dataPanierPrestation
                $dataPanierRendezVous[] =
                    [
                        'date_rdv' => $dateRdv,
                        'statut' => $statut,
                        'prestation' => $prestation,
                    ];
            }
        }
        return $dataPanierRendezVous;
    }


    private function getTotal($dataPanierArticle, $dataPanierPrestation)
    {
        $total = 0;
        foreach ($dataPanierArticle as $item) {
            // dd($item);
            $total += $item['article']->getPrixArticle() * floatval($item['quantite']);
        }

        foreach ($dataPanierPrestation as $item) {

            $total += $item['prestation']->getPrixPrestation() * 1;
        }

        return $total;
    }


    //Ajouter un article 
    /**
     * @Route("/add/{id}", name="add_article", requirements={"id"="\d+"})
     */
    public function addArticle(Article $article, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        $id_article = $article->getId();
        if (!empty($panier[$id_article])) {
            $panier[$id_article]++;
        } else {
            $panier[$id_article] = 1;
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/prestation/add/{id}", name="add_prestation", requirements={"id"="\d+"})
     */
    public function addPrestation(Prestation $prestation, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        $id_prestation = $prestation->getId();

        $panier[$id_prestation]['quantite'] = 1;
        // dd($panier);

        $session->set('panier', $panier);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/remove_article/{id}", name="remove_article", requirements={"id"="\d+"})
     */
    public function removeArticle(Article $article, SessionInterface $session)
    {
        // on r??cup??re le panier actuel

        $panier = $session->get('panier', []);
        $id = $article->getId();

        if (!empty($panier[$id])) {
            $panier[$id]--;
        } else {
            unset($panier[$id]);
        }

        // On sauvegarde dans la session

        $session->set('panier', $panier);

        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/delete_all", name="delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
        // on r??cup??re le panier actuel

        $session->remove('panier');

        return $this->redirectToRoute('cart_index');
    }
    /**
     * @Route("/delete_one_article/{id}", name="delete_one_article", requirements={"id"="\d+"})
     */
    public function deleteOneArticle(Article $article, SessionInterface $session)
    {
        // on r??cup??re le panier actuel

        $panier = $session->get('panier', []);
        $id_article = $article->getId();
        if (!empty($panier[$id_article])) {
            unset($panier[$id_article]);
        }

        // On sauvegarde dans la session

        $session->set('panier', $panier);

        return $this->redirectToRoute('cart_index');
    }
    /**
     * @Route("/delete_one_prestation/{id}", name="delete_one_prestation", requirements={"id"="\d+"})
     */
    public function deleteOnePrestation(Prestation $prestation, SessionInterface $session)
    {
        // on r??cup??re le panier actuel

        $panier = $session->get('panier', []);
        $id_prestation = $prestation->getId();
        if (!empty($panier[$id_prestation])) {
            unset($panier[$id_prestation]);
        }

        // On sauvegarde dans la session

        $session->set('panier', $panier);

        return $this->redirectToRoute('cart_index');
    }
}
