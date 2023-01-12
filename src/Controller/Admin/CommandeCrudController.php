<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commande')
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setEntityLabelInPlural('Commandes')
            ->setDateFormat('d/m/Y')
            ->setPageTitle('index', 'Commandes')
            ->setPaginatorPageSize(10)
            // ...
        ;
    }

    // public function configureFields(string $pageName): iterable
    // {
    //     return [
    //         IdField::new('id'),
    //         TextField::new('total_commande'),
    //         ArrayField::new('ligneDeCommandes'),
    //         DateTimeField::new('date_commande'),
    //     ];
    // }
}
