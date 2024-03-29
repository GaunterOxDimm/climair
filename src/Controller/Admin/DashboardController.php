<?php

namespace App\Controller\Admin;

use App\Entity\Rdv;
use App\Entity\Article;
use App\Entity\Commande;
use App\Entity\Prestation;
use App\Entity\Utilisateur;
use App\Entity\LigneDeCommande;
use App\Entity\CategorieArticle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\CommandeCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(CommandeCrudController::class)->generateUrl();
        return $this->redirect($url);
    }
    public function title(): Response
    {

        $title = 'Climair - Administation';
        return $this->render('admin/dashboard.html.twig', [
            'title' => $title,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony Climair')
            // the name visible to end users
            ->setTitle('CLIMAIR Corp.')
            // you can include HTML contents too (e.g. to link to an image)
            ->setTitle('<img src="./assets/img/clim_telecommande.jpeg"> CLIMAIR <span class="text-small">Corp.</span>')
            // set this option if you prefer the page content to span the entire
            // browser width, instead of the default design which sets a max width
            ->renderContentMaximized()
            // by default EasyAdmin displays a black square as its default favicon;
            // use this method to display a custom favicon: the given path is passed
            // "as is" to the Twig asset() function:
            // <link rel="shortcut icon" href="{{ asset('...') }}">
            ->setFaviconPath('favicon.svg')
            // set this option if you want to enable locale switching in dashboard.
            // IMPORTANT: this feature won't work unless you add the {_locale}
            // parameter in the admin dashboard URL (e.g. '/admin/{_locale}').
            // the name of each locale will be rendered in that locale
            // (in the following example you'll see: "English", "Polski")
            ->setLocales(['en', 'fr'])
            ->setLocales([
                'en' => '🇬🇧 English',
                'fr' => '🇫🇷 French'
            ]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', Utilisateur::class);
        yield MenuItem::linkToCrud('Commande', 'fa fa-truck-fast', Commande::class);
        yield MenuItem::linkToCrud('Article', 'fa fa-truck-fast', Article::class);
        yield MenuItem::linkToCrud('Categorie Article', 'fa fa-truck-fast', CategorieArticle::class);
        yield MenuItem::linkToCrud('Ligne de commande', 'fa fa-truck-fast', LigneDeCommande::class);
        yield MenuItem::linkToCrud('Prestation', 'fa fa-truck-fast', Prestation::class);
        yield MenuItem::linkToCrud('Rdv', 'fa fa-truck-fast', Rdv::class);
    }
}
