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
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private readonly ManagerRegistry   $managerRegistry,
                                private readonly AdminUrlGenerator $adminUrlGenerator)
    {
    }

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
        yield MenuItem::linkToCrud('Пользователи', 'fa-solid fa-user', User::class);
        yield MenuItem::linkToCrud('Обратная связь', 'fa-solid fa-comment', Feedback::class);
        yield MenuItem::linkToCrud('Отзывы', 'fa-solid fa-comments', Review::class);
        yield MenuItem::linkToCrud('Контакты', 'fa-solid fa-address-book', Contact::class);
        yield MenuItem::linkToCrud('Соц.сети', 'fa-brands fa-telegram', Social::class);
        yield MenuItem::linkToCrud('Локации', 'fa-sharp fa-solid fa-city', Location::class);
        yield MenuItem::linkToCrud('Галерея', 'fa-sharp fa-solid fa-images', Gallery::class);

        yield MenuItem::section('Секции на страницах', 'fa-sharp fa-solid fa-puzzle-piece');

        yield MenuItem::linkToUrl('Добавить секцию', 'fa-solid fa-plus', $this->adminUrlGenerator
            ->unsetAll()
            ->setController(PageSectionCrudController::class)
            ->setAction(Crud::PAGE_INDEX)
            ->generateUrl()
        );

        foreach ($this->getSectionMenu() as $value) {
            list($label, $icon, $url) = $value;
            yield MenuItem::linkToUrl($label, $icon, $url);
        }
    }

    public function getSectionMenu(): array
    {
        $dataSectionMenu = [];
        $sections = $this->managerRegistry->getRepository(PageSection::class)->findAll();

        foreach ($sections as $section) {
            $sectionType = array_search($section->getType(), PageSection::getAvailableSectionType());
            if (!array_key_exists($sectionType, $dataSectionMenu)) {
                $url = $this->adminUrlGenerator
                    ->unsetAll()
                    ->setController(PageSectionCrudController::class)
                    ->setAction(Crud::PAGE_INDEX)
                    ->set('type', $section->getType())
                    ->generateUrl();

                $dataSectionMenu[$sectionType] = [$sectionType, false, $url];
            }
        }

        return $dataSectionMenu;
    }
}
