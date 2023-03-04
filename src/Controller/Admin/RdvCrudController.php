<?php

namespace App\Controller\Admin;

use App\Entity\Rdv;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RdvCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rdv::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('statut'),
            DateTimeField::new('date_rdv'),
            AssociationField::new('utilisateur'),
            AssociationField::new('prestation')
        ];
    }
}
