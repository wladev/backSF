<?php

namespace App\Controller\Admin;

use App\Entity\WebContact;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Vich\UploaderBundle\Form\Type\VichFileType;



class WebContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WebContact::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            TextField::new('lstName', 'Nom'),
            TextField::new('fstName', 'Prénom'),
            ChoiceField::new('isAn', 'Statut')
                ->setChoices([
                    'Particulier' => 1,
                    'Entreprise' => 2,
                ]),
            TextField::new('email', 'Email'),
            ChoiceField::new('situation', 'Situation Professionnelle')
                ->setChoices([
                    'Etudiant' => 1,
                    'Actif' => 2,
                    'Demandeur d\'emploi' => 3,
                    'Entreprise' => 4,
                ]),
            TextEditorField::new('needs', 'Message envoyé'),
            ChoiceField::new('knowSz', 'A connu Start-Zup par')
                ->setChoices([
                    'Internet' => 1,
                    'Reseau personnel' => 2,
                    'Pôle emploi / Mission locale' => 3,
                    'Autre' => 4,
                ]),
            // FileField::new('cvFile')
            //     ->setFormType(VichFileType::class)
            //     ->onlyOnForms(),
            TextField::new('cvFile', 'Fichier')
                ->hideOnIndex()
                ->setFormType(VichFileType::class),
            TextField::new('cvFileName')
                ->onlyOnIndex(),
            DateTimeField::new('updatedAt')
                ->hideOnForm(),
        ];
    }
}
