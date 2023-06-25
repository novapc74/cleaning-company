<?php

namespace App\Controller;

use App\Entity\FeedBack;
use App\Form\FeedBackFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedBackController extends AbstractController
{
    #[Route('/feed/back', name: 'app_feed_back', methods: ['GET', 'POST'])]
    public function index(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $feedBack = new FeedBack();
        $form = $this->createForm(FeedBackFormType::class, $feedBack);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $feedBack = $form->getData();

            $em = $managerRegistry->getManager();
            $em->persist($feedBack);
            $em->flush();

            return new Response(true, 201);
        }

        $prefix = $request->isXmlHttpRequest() ? 'form': 'feed_back';

        return $this->render("feed_back/{$prefix}.html.twig", [
            'feedBackForm' => $form->createView(),
        ]);
    }
}
