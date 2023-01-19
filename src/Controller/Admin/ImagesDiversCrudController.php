<?php

namespace App\Controller\Admin;

use App\Entity\ImagesDivers;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImagesDiversCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ImagesDivers::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Image')
            ->setEntityLabelInPlural('Images')
            ->setDateFormat('d/m/Y')
            ->setPageTitle('index', 'Images Divers')
            ->setPaginatorPageSize(10)
            // ...
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('nom_image'),
            ImageField::new('adresse_image')
                ->setUploadDir('public/assets/img'),
        ];
    }
}
