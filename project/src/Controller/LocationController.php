<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    #[Route('/location', name: 'app_location')]
    public function index(LocationRepository $locationRepository): JsonResponse
    {
        return $this->json($locationRepository->findAll(), 200, [], [
            AbstractNormalizer::GROUPS => ['location:list']
        ]);
    }
}
