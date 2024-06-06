<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bundle\SecurityBundle\Security as SecurityBundleSecurity;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_VERIFIED')]
class EventCrudController extends AbstractCrudController
{
    private $security;

    public function __construct(SecurityBundleSecurity $security)
    {
        $this->security = $security;
    }


    public function createEntity(string $entityFqcn)
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'avez pas les droits pour créer un évenement.');
            return $this->redirectToRoute('app_acces_denied', [], Response::HTTP_SEE_OTHER);
        }

        $post = new Event();
        $post->setAddBy($this->security->getUser());

        return $post;
    }

    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        
        return $crud

        ->setPageTitle('index', 'Liste des %entity_label_plural%')
        ->setEntityLabelInSingular('Evenement')
        ->setEntityLabelInPlural('Evenements')
        ->setPaginatorPageSize(10);

    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->onlyOnDetail(),
            DateTimeField::new('date_event', 'date de l\'événement'),
            DateTimeField::new('date_end', 'date de fin (optionnel)'),
            ChoiceField::new('guest', 'invité du vendredi ?')
            ->setChoices([
                'Non' => 0,
                'oui' => 1,
            ]),
            TextField::new('theme'),
            TextField::new('description'),
            TextField::new('link', 'lien https://....'),
            TextField::new('lieu'),
            TextField::new('photo', 'Photo')
            ->onlyOnForms()
            ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('photoFile', 'Fichier')
            ->hideOnIndex()
            ->setFormType(VichImageType::class),
            ImageField::new('photo', 'Fichier de la photo')
            ->onlyOnDetail()
            ->setBasePath('/public/img'),
            TextField::new('guestName', 'Nom de l\'invité (si guest du vendredi)'),
            TextField::new('guestTitle', 'Poste occupé par l\'invité'),
            TextField::new('guestCompany', 'Entreprise de l\'invité'),
            TextField::new('addBy.username', 'Posté par')
            ->setFormTypeOption('disabled', 'disabled'),
            DateTimeField::new('createdAt', 'Posté le')
                ->setFormTypeOption('disabled', 'disabled'),
        ];
    }
}
