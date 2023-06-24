<?php

namespace App\Controller;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController
{
    private CacheManager $imagineCacheManager;
    public function __construct(CacheManager $imagineCacheManager)
    {
        $this->imagineCacheManager = $imagineCacheManager;
    }

    /**
     * Сюда попадают запросы на кэшированные картинки, если их пока еще нет. Это позволяет не использовать ссылки вида /resolve и twig-фильтр imagine_filter(),
     * а вместо этого ссылки на картинки всегда будут иметь вид /cache/media/..., которые выводит фильтр imagine_filter_cache()
     */
    #[Route('/cache/media/{img_size}/{img_path}', requirements: ["img_size" => "^(?!resolve)\w+","img_path" => ".+"], priority: 40)]
    public function sizedImage(Request $request): Response
    {
        $img_path = $request->attributes->get('img_path');
        $img_size = $request->attributes->get('img_size');

        return $this->redirect($this->imagineCacheManager->getBrowserPath($img_path, $img_size));
    }
}

