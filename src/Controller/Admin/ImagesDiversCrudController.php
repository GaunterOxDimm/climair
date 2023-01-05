<?php

namespace App\Controller\Admin;

use App\Entity\ImagesDivers;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

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
            IdField::new('id'),
            TextField::new('nom image'),
            TextEditorField::new('description'),
        ];
    }
}
