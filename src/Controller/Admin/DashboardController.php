<?php

//DashboardController.php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\WebContact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'admin')]
    #[IsGranted('ROLE_VERIFIED')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
        return $this->render('admin/dashboard.html.twig', ['favicon_path' => '/img/logo_admin.png']);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // ->setLocales(['fr', 'en'])
            // ->setDateFormat('dd/mm/YY')
            ->setFaviconPath('img/logo_admin.png')
            ->setTitle('Administration Web Start-Zup')
            ->renderContentMaximized();
        }

        public function configureMenuItems(): iterable
        {
            // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home pb-5');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Articles de presse', 'fas fa-newspaper', Post::class);
        yield MenuItem::linkToCrud('Demandes de contact site web', 'fas fa-address-book', WebContact::class);
        // yield MenuItem::linkToRoute('Mon Compte', 'fas fa-user-cog', '??????');
    }

}
