<?php

namespace App\Controller\Admin;

use App\Entity\LigneDeCommande;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LigneDeCommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LigneDeCommande::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Ligne de Commande')
            ->setEntityLabelInPlural('Lignes de Commande')
            ->setDateFormat('d/m/Y')
            ->setPageTitle('index', 'Lignes de Commandes')
            ->setPaginatorPageSize(10)
            // ...
        ;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            IntegerField::new('quantite'),
            AssociationField::new('commande'),
            AssociationField::new('article'),
            AssociationField::new('prestation')
        ];
    }
}
