<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
            MoneyField::new('prix_article')
                ->setCurrency('EUR')
                ->setCustomOption(MoneyField::OPTION_STORED_AS_CENTS, false),
            ImageField::new('img_article')
                ->setBasePath('assets/img_article_directory/') // chemin dossier local images
                ->setUploadDir('public/assets/img_article_directory/')
                ->setRequired(false),
            TextEditorField::new('description_article')->setFormTypeOption('format', 'html'),
            AssociationField::new('categorieArticle'),
            AssociationField::new('ligneDeCommande'),
            IntegerField::new('stock')
        ];
    }
}
