<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Hall;
use App\Entity\HallSeatType;
use App\Entity\SeatType;
use App\Entity\Session;
use App\Entity\SessionSeatType;
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

    //Sub Menu principal
    yield MenuItem::subMenu('Concerts management', 'fas fa-music')->setSubItems([
        MenuItem::linkToCrud('Events', 'fas fa-music', Event::class),
        MenuItem::linkToCrud('Artists', 'fas fa-user', Artist::class),
    ]);

    // Sub Menu Place
    yield MenuItem::subMenu('Place', 'fas fa-map-marker-alt')->setSubItems([
        MenuItem::linkToCrud('Hall', 'fas fa-building', Hall::class),
        MenuItem::linkToCrud('Hall Seat Types', 'fas fa-couch', HallSeatType::class),
    ]);

    // Sub Menu Configuration
    yield MenuItem::subMenu('Configuration', 'fas fa-cogs')->setSubItems([
        MenuItem::linkToCrud('Sessions', 'fas fa-calendar-alt', Session::class),
        MenuItem::linkToCrud('Categories', 'fas fa-tags', Category::class),
        MenuItem::linkToCrud('Seat Types', 'fas fa-chair', SeatType::class),
        MenuItem::linkToCrud('Sessions/Seat Types', 'fas fa-chair', SessionSeatType::class),
    ]);
}

}
