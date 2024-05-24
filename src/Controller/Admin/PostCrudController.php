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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_USER')]
class PostCrudController extends AbstractCrudController implements CrudControllerInterface
{

    private $security;

    public function __construct(SecurityBundleSecurity $security)
    {
        $this->security = $security;
    }


    public function createEntity(string $entityFqcn)
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'avez pas les droits pour créer un post.');
            return $this->redirectToRoute('app_acces_denied', [], Response::HTTP_SEE_OTHER);
        }

        $post = new Post();
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
                ->hideOnForm()
                ->onlyOnDetail(),
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
