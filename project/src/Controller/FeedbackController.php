<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FooterFeedbackFormType;
use App\Form\PopupFeedbackFormType;
use App\Message\EmailNotification;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
	public function __construct(private readonly ManagerRegistry     $managerRegistry,
	                            private readonly MessageBusInterface $bus)
	{
	}

	#[Route('/feedback/popup', name: 'app_feedback_footer', methods: ['GET', 'POST'])]
	public function resolveFooterForm(Request $request): Response
	{
		return $this->resolveForm(PopupFeedbackFormType::class, $request);
	}

	#[Route('/feedback/footer', name: 'app_feedback_popup', methods: ['GET', 'POST'])]
	public function resolvePopupForm(Request $request): Response
	{
		return $this->resolveForm(FooterFeedbackFormType::class, $request);
	}

	private function resolveForm(string $formType, Request $request): Response
	{
		if (!$request->isXmlHttpRequest()) {
			return $this->redirectToRoute('app_home_page');
		}

		$feedBack = new Feedback();

		$form = $this->createForm($formType, $feedBack);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$feedBack = $form->getData();

			$em = $this->managerRegistry->getManager();
			$em->persist($feedBack);
			$em->flush();

			$this->bus->dispatch(new EmailNotification($feedBack));

			return $this->json(['success' => true], 201);
		}

		return $this->render("feedback/form.html.twig", [
			'feedbackForm' => $form->createView()
		]);
	}
}
