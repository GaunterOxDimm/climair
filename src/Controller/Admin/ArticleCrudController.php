<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Article')
            ->setEntityLabelInPlural('Articles')
            ->setDateFormat('d/m/Y')
            ->setPageTitle('index', 'Articles')
            ->setPaginatorPageSize(10)
            // ...
        ;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom_article'),
            MoneyField::new('prix_article')->setCurrency('EUR'),
            ImageField::new('img_article')
                ->setBasePath('assets/img_article_directory/') // chemin dossier local images
                ->setUploadDir('public/assets/img_article_directory/')
                ->setRequired(false),
            TextField::new('description_article'),
            AssociationField::new('categorieArticle'),
            AssociationField::new('ligneDeCommande'),
            IntegerField::new('stock')
        ];
    }
}
