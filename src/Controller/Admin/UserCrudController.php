<?php

//UserCrudController.php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DomCrawler\Field\FileFormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud

        ->setPageTitle('index', 'Liste des %entity_label_plural%')
        ->setEntityLabelInSingular('Utilisateur')
        ->setEntityLabelInPlural('Utilisateurs')
        ->setPaginatorPageSize(5);

    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnDetail(),
            TextField::new('userName', 'Nom d\'utilisateur'),
            EmailField::new('email'),
            ArrayField::new('roles', 'Rôle'),
            // TextField::new('password', 'Mot de passe'),

            // ChoiceField::new('roles', 'Rôle')
            //     ->setChoices([
            //         'ROLE_USER' => "ROLE_USER",
            //         'ROLE_ADMIN' => "ROLE_ADMIN",
            //     ])
            ChoiceField::new('isVerified', 'Autorisation d\'accès')
                ->setChoices([
                    'Non autorisé' => 0,
                    'Autorisé' => 1,
                ]),
        ];
    }
    
}
