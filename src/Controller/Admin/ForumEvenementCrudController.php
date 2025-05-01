<?php

namespace App\Controller\Admin;

use App\Entity\ForumEvenement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ForumEvenementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ForumEvenement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('titre'),
            AssociationField::new('evenement'),
        ];
    }
}
