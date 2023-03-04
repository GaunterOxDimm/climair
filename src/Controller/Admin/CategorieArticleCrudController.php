<?php

namespace App\Controller\Admin;

use App\Entity\CategorieArticle;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CategorieArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategorieArticle::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Categorie Article')
            ->setEntityLabelInPlural('Categories Articles')
            // ->setDateFormat('d/m/Y')
            ->setPageTitle('index', 'Categorie Article')
            ->setPaginatorPageSize(10)
            // ...
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('nom_categorie'),
            // AssociationField::new('article')
        ];
    }
}
