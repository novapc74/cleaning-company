<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Service\MailerService;
use App\Message\EmailNotification;
use App\Form\Admin\FeedbackFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class FeedbackController extends AbstractController
{
	/**
	 * @throws TransportExceptionInterface
	 */
	#[Route('/feedback', name: 'app_feedback', methods: ['GET', 'POST'])]
	public function index(Request $request,
	                      ManagerRegistry $managerRegistry,
	                      MailerService $mailerService, MessageBusInterface $bus): Response
	{
		if (!$request->isXmlHttpRequest()) {
			return $this->redirectToRoute('app_home_page');
		}

		$identifier = $request->query->get('identifier', 'none');

		$feedBack = new Feedback();
		$form = $this->createFormBuilder($feedBack)
			->create($identifier, FeedbackFormType::class)
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$feedBack = $form->getData();

			$em = $managerRegistry->getManager();
			$em->persist($feedBack);
			$em->flush();

//			$mailerService->resolveMailer($feedBack);

			$bus->dispatch(new EmailNotification($mailerService, $feedBack));

			return $this->json(['success' => true], 201);
		}

		return $this->render("feedback/form.html.twig", [
			'feedbackForm' => $form->createView()
		]);
	}
}
