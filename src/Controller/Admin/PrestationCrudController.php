<?php

namespace App\Controller\Admin;

use App\Entity\Prestation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PrestationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Prestation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Prestation')
            ->setEntityLabelInPlural('Prestations')
            ->setDateFormat('d/m/Y')
            ->setPageTitle('index', 'Prestation')
            ->setPaginatorPageSize(10)
            // ...
        ;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('nom'),
            MoneyField::new('prix_prestation')->setCurrency('EUR')
                ->setStoredAsCents(),
            ImageField::new('img_prestation')
                ->setBasePath('assets/img_prestation_directory/') // chemin dossier local images
                ->setUploadDir('public/assets/img_prestation_directory/')
                ->setRequired(false),
            TextField::new('description_prestation'),
            AssociationField::new('lignedecommande'),

        ];
    }
}
