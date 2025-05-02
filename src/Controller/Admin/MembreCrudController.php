<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
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
            ChoiceField::new('role')
                ->setLabel('Rôle')
                ->setChoices([
                    'Utilisateur' => 'USER',
                    'Administrateur' => 'ADMIN'
                ])
                ->allowMultipleChoices(false)  // Permet uniquement un seul choix
                ->setFormTypeOption('expanded', false)  // Liste déroulante
                ->setFormTypeOption('multiple', false),  // Permet un seul choix
            EmailField::new('email'),
            AssociationField::new('promo'),
        ];

        if ($pageName !== 'index') {
            $fields[] = TextField::new('password')
                ->setFormTypeOption('attr', [
                    'type' => 'password',
                    'autocomplete' => 'new-password'  // Empêche les suggestions du navigateur
                ])
                ->setFormTypeOption('empty_data', '')
                ->setFormTypeOption('data', null)
                ->setRequired(false)
                ->onlyOnForms();
        }

        return $fields;
    }
}
