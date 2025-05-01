<?php

namespace App\Controller\Admin;

use App\Entity\MessageProjet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class MessageProjetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MessageProjet::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('message'),
            DateField::new('dateMessage'),
            AssociationField::new('membre'),
            AssociationField::new('forumProjet'),
        ];
    }
}
