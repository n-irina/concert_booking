<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Hall;
use App\Entity\Session;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Concert_booking');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Category', 'fas fa-tags', Category::class);
        yield MenuItem::linkToCrud('Artist', 'fas fa-user', Artist::class);
        yield MenuItem::linkToCrud('Event', 'fas fa-music', Event::class);
        yield MenuItem::linkToCrud('Hall', 'fas fa-building', Hall::class);
        yield MenuItem::linkToCrud('Session', 'fas fa-calendar-alt', Session::class);
    }
}
