<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Review;
use App\Entity\Gallery;
use App\Entity\Feedback;
use App\Entity\Social;
use App\Entity\User;
use App\Entity\Location;
use App\Entity\PageSection;
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
        yield MenuItem::linkToCrud('Обратная связь', 'fa-solid fa-comments', Feedback::class);
	    yield MenuItem::linkToCrud('Отзывы', 'fa-solid fa-comments', Review::class);
        yield MenuItem::linkToCrud('Контакты', 'fa-solid fa-contacts', Contact::class);
        yield MenuItem::linkToCrud('Соц.сети', 'fa-solid fa-social', Social::class);
	    yield MenuItem::linkToCrud('Локации', 'fa-solid fa-social', Location::class);
	    yield MenuItem::linkToCrud('Галерея', 'fa-solid fa-social', Gallery::class);
	    yield MenuItem::linkToCrud('Секции на страницах', 'fa-solid fa-social', PageSection::class);
    }
}
