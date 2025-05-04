<?php

namespace App\Controller\Admin;

use App\Entity\ForumEvenement;
use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ForumEvenementCrudController extends AbstractCrudController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return ForumEvenement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('titre'),
            AssociationField::new('evenement')
                ->setFormTypeOption('query_builder', function ($repository) {
                    return $repository->createQueryBuilder('e')
                        ->leftJoin('e.forumEvenement', 'f')
                        ->where('f.id IS NULL');
                }),
        ];
    }
}
