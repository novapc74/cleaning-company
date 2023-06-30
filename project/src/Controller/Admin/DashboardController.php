<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use App\Entity\FeedBack;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('@EasyAdmin/page/content.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<span style="color: red">CLEANING COMPANY</span>');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Пользователи', 'fa-solid fa-user-secret', User::class);
        yield MenuItem::linkToCrud('Обратная связь', 'fa-solid fa-comments', FeedBack::class);
	    yield MenuItem::linkToCrud('Отзывы', 'fa-solid fa-comments', Review::class);
    }
}
