<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Controller\CrudControllerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security as SecurityBundleSecurity;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Security\Core\Security;

class PostCrudController extends AbstractCrudController implements CrudControllerInterface
{

    private $security;

    public function __construct(SecurityBundleSecurity $security)
    {
        $this->security = $security;
    }

    // Autres méthodes de configuration...

    public function createEntity(string $entityFqcn)
    {
        $post = new Post();
        
        // Attribuer automatiquement l'utilisateur connecté comme l'utilisateur associé à la publication
        $post->setPostBy($this->security->getUser());
        
        return $post;
    }

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud

        ->setPageTitle('index', 'Liste des %entity_label_plural%')
        ->setEntityLabelInSingular('Article')
        ->setEntityLabelInPlural('Articles')
        ->setPaginatorPageSize(5);

    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextField::new('description'),
            TextField::new('link', 'Lien')
                ->onlyOnForms(),
                // ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('picture', 'Photo')
                ->onlyOnForms()
                ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('pictureFile', 'Fichier')
                ->hideOnIndex()
                ->setFormType(VichImageType::class),
            ImageField::new('picture', 'Fichier de la photo')
                ->onlyOnDetail()
                ->setBasePath('/public/img'),
            TextField::new('postBy.username', 'Posté par')
            ->setFormTypeOption('disabled', 'disabled'),
            DateTimeField::new('createdAt', 'Posté le')
            ->setFormTypeOption('disabled', 'disabled'),
        ];
    }
    
}
