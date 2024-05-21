<?php

namespace App\Controller\Admin;

use App\Entity\WebContact;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WebContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WebContact::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ChoiceField::new('isAn', 'Statut')
                ->setChoices([
                    'Particulier' => 1,
                    'Entreprise' => 2,
                ]),
            TextField::new('lstName', 'Nom'),
            TextField::new('fstName', 'Prénom'),
            TextField::new('email', 'Email'),
            ChoiceField::new('situation', 'Situation Professionnelle')
                ->setChoices([
                    'Etudiant' => 1,
                    'Actif' => 2,
                    'Demandeur d\'emploi' => 3,
                    'Entreprise' => 4,
                ]),
            TextField::new('needs', 'Message envoyé'),
            ChoiceField::new('knowSz', 'A connu Start-Zup par')
                ->setChoices([
                    'Internet' => 1,
                    'Reseau personnel' => 2,
                    'Pôle emploi / Mission locale' => 3,
                    'Autre' => 4,
                ]),
        ];
    }
}
