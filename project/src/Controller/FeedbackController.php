<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
	#[Route('/feedback', name: 'app_feedback', methods: ['GET', 'POST'])]
	public function index(Request $request, ManagerRegistry $managerRegistry): Response
	{
		if (!$request->isXmlHttpRequest()) {
			return $this->redirectToRoute('app_home_page');
		}

		$feedBack = new Feedback();
		$form     = $this->createForm(FeedbackFormType::class, $feedBack);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$feedBack = $form->getData();

			$em = $managerRegistry->getManager();
			$em->persist($feedBack);
			$em->flush();

			return new Response(true, 201);
		}

		return $this->render("feedback/form.html.twig", [
			'feedbackForm' => $form->createView(),
		]);
	}
}
