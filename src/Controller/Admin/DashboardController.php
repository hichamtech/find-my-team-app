<?php

namespace App\Controller\Admin;

use App\Entity\City;
use App\Entity\Post;
use App\Entity\PostType;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;

/**
 * Class DashboardController
 * @package App\Controller\Admin
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        $url = $routeBuilder->setController(UserCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    /**
     * @return Dashboard
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Panel')
            ;

    }


    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Post', 'fas fa-dollar-sign', Post::class);
        yield MenuItem::linkToCrud('Post Type', 'fas fa-home', PostType::class);
        yield MenuItem::linkToCrud('City', 'fas fa-home', City::class);

      
    }
}
