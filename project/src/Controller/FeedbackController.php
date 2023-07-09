<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\Admin\FeedbackFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FeedbackController extends AbstractController
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {
    }

//    #[Route('/feedback', name: 'app_feedback', methods: ['GET', 'POST'])]
//	public function index(Request $request, ManagerRegistry $managerRegistry): Response
//	{
//		if (!$request->isXmlHttpRequest()) {
//			return $this->redirectToRoute('app_home_page');
//		}
//
//		$feedBack = new Feedback();
//		$form     = $this->createForm(FeedbackFormType::class, $feedBack);
//
//		$form->handleRequest($request);
//		if ($form->isSubmitted() && $form->isValid()) {
//			$feedBack = $form->getData();
//
//			$em = $managerRegistry->getManager();
//			$em->persist($feedBack);
//			$em->flush();
//
//			return new Response(true, 201);
//		}
//
//		return $this->render("feedback/form.html.twig", [
//			'feedbackForm' => $form->createView(),
//		]);
//	}

    #[Route('/feedback_header', name: 'app_feedback_header', methods: ['POST'])]
    public function setHeaderFeedback(Request $request): Response
    {
        $this->setFeedbackData($request);

        return new Response(true, 201);
    }

    #[Route('/feedback_footer', name: 'app_feedback_footer', methods: ['POST'])]
    public function setFooterFeedback(Request $request): Response
    {
        $this->setFeedbackData($request);

        return new Response(true, 201);
    }

    private function setFeedbackData($request): void
    {
        $feedback = new Feedback();

        $feedback->setName($request->request->get('name'));
        $feedback->setEmail($request->request->get('email'));
        $feedback->setPhone($request->request->get('phone'));

        $em = $this->managerRegistry->getManager();
        $em->persist($feedback);
        $em->flush();
    }
}
