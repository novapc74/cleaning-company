<?php

namespace App\Controller;

use App\Repository\GalleryRepository;
use App\Repository\PageSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(PageSectionRepository $pageSectionRepository, GalleryRepository $galleryRepository): Response
    {
        return $this->render('pages/home.html.twig', [
            'about_us' => $pageSectionRepository->findOneBy(['type' => 6]),
	        'about_collection' => $pageSectionRepository->findBy(['type' => 5]),
	        'how_it_works_collection' => $pageSectionRepository->findBy(['type' => 1]),
	        'question_answer_collection' => $pageSectionRepository->findBy(['type' => 2]),
	        'services_collection' => $pageSectionRepository->findBy(['type' => 3]),
	        'advantages_collection' => $pageSectionRepository->findBy(['type' => 4]),
	        'gallery_collection' => $galleryRepository->findBy(['type' => 1]),
        ]);
    }
}
