<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use Doctrine\ORM\EntityManagerInterface;  // Correcte importation
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class MembreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Membre::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('role'),
            EmailField::new('email'),
            AssociationField::new('promo'),
        ];

        if ($pageName !== 'index') {
            // Ajoute le champ password uniquement si ce n'est pas la vue "index"
            $fields[] = TextField::new('password')
                ->setFormTypeOption('attr', ['type' => 'password']);  // Masquer les caractères
        }

        return $fields;
    }
}
