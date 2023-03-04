<?php

namespace App\Controller;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use TCPDF;
use App\Entity\Commande;
use App\Entity\Utilisateur;
use App\Repository\ArticleRepository;
use App\Repository\CommandeRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LigneDeCommandeRepository;
use App\Repository\PrestationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PDFController extends AbstractController
{

    #[Route('/p/d/f', name: 'app_p_d_f')]
    public function index(): Response
    {
        return $this->render('pdf/index.html.twig', [
            'controller_name' => 'PDFController',
        ]);
    }

    // /**
    //  * @Route("/pdf/{id}", name="pdf")
    //  * @ParamConverter("commande", class="App\Entity\Commande")
    //  */
    /**
     * @Route("/pdf/{id}", name="app_pdf", requirements={"id"="\d+"})
     * @ParamConverter("commande", class="App\Entity\Commande")
     */

    public function generatePdf(SessionInterface $session, ArticleRepository $articleRepository, PrestationRepository $prestationRepository): Response
    {
        // dump($commande);
        $panier = $session->get('panier', []);
        // $commandeId = $commande->getId();
        // // $utilisateur = $this->getUser(); // On récupère l'objet Utilisateur connecté
        // $currentUser = $commande->getUtilisateur();
        // $username = $currentUser->getNomUtilisateur();
        // $emailUser = $currentUser->getEmail();

        // Création de l'objet PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Configuration des paramètres PDF
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Climair');
        $pdf->SetTitle('Facture');
        $pdf->SetSubject('Facture');
        $pdf->SetKeywords('Facture, PDF');

        // Désactivation des en-têtes et pieds de page
        // $pdf->setPrintHeader(false);
        // $pdf->setPrintFooter(false);
        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Commande n° ', 'Climair', array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Définition des marges
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        // Ajout de la première page
        $pdf->AddPage();
        // Line
        $pdf->Text(5, 4, 'Line examples');

        // Rect
        $pdf->Text(100, 4, 'Rectangle examples');

        $html = '<h1>HTML Example</h1>';

        $pdf->writeHTML(
            $html,
            true,
            false,
            true,
            false,
            ''
        );

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(30, 10, 'Image', 1, 0, 'C', 0);
        $pdf->Cell(30, 10, 'Article', 1, 0, 'C', 0);
        $pdf->Cell(30, 10, 'Catégorie', 1, 0, 'C', 0);
        $pdf->Cell(30, 10, 'Description', 1, 0, 'C', 0);
        $pdf->Cell(
            30,
            10,
            'Prix unitaire',
            1,
            0,
            'C',
            0
        );
        $pdf->Cell(30, 10, 'Prix total', 1, 0, 'C', 0);
        $pdf->Ln(); // Permet de se déplacer à la ligne suivante

        // Boucle pour ajouter les articles du panier à la facture
        foreach ($panier as $id => $quantite) {

            $article = $articleRepository->find($id);
            $prestation = $prestationRepository->find($id);
            if ($article) {
                $imageA = "/assets/img_article_directory/" . $article->getImgArticle();
                $pdf->Cell(
                    30,
                    40,
                    $pdf->Image($imageA, 5, $pdf->GetX(), $pdf->GetY(), 33.78),
                    0,
                    0,
                    'L',
                    false
                );

                $pdf->Cell(30, 10, $article->getNomArticle(), 1, 0, 'C');
                $pdf->Cell(30, 10, $article->getCategorieArticle(), 1, 0, 'C');
                $pdf->Cell(30, 10, $article->getDescriptionArticle(), 1, 0, 'C');
                $pdf->Cell(30, 10, $article->getPrixArticle(), 1, 0, 'C');
                $pdf->Cell(30, 10, $article->getPrixArticle() * $quantite, 1, 0, 'C');
                $pdf->Ln(); // Permet de se déplacer à la ligne suivante
            }
            if ($prestation) {
                $imageP = "/assets/img_prestation_directory/" . $prestation->getImgPrestation();
                $pdf->Cell(
                    30,
                    40,
                    $pdf->Image($imageP, 5, $pdf->GetX(), $pdf->GetY(), 33.78),
                    0,
                    0,
                    'L',
                    false
                );

                $pdf->Cell(30, 10, $prestation->getNom(), 1, 0, 'C');
                $pdf->Cell(30, 10, $prestation->getDescriptionPrestation(), 1, 0, 'C');
                $pdf->Cell(30, 10, $prestation->getPrixPrestation(), 1, 0, 'C');
                $pdf->Cell(30, 10, $prestation->getPrixPrestation() * $quantite, 1, 0, 'C');
                $pdf->Ln(); // Permet de se déplacer à la ligne suivante
            }
        }

        // Enregistrement du fichier PDF
        $pdf->Output('facture.pdf', 'I');
        // Envoi du PDF au navigateur
        return new Response($pdf->Output('panier.pdf', 'I'), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="panier.pdf"'
        ]);
    }
}
