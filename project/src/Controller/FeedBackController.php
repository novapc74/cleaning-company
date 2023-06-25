<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedBackController extends AbstractController
{
    #[Route('/feed/back', name: 'app_feed_back')]
    public function index(): Response
    {
        return $this->render('feed_back/index.html.twig', [
            'controller_name' => 'FeedBackController',
        ]);
    }
}
