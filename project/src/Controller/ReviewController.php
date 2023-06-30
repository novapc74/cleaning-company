<?php

namespace App\Controller;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use App\Controller\Trait\PaginationTrait;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
	use PaginationTrait;

	private const ITEM_PER_PAGE = 9;

	#[Route('/review', name: 'app_review')]
	public function index(Request $request, ReviewRepository $reviewRepository, PaginatorInterface $paginator): Response
	{
		$reviews = $reviewRepository->findAll();

		$currentPage = $request->query->getInt('page', 1);

		$pagination = $paginator->paginate(
			$reviews,
			$currentPage,
			self::ITEM_PER_PAGE
		);

		return $this->render('review/index.html.twig', [
			'reviews' => $pagination,
			'currentPage' => $currentPage,
			'lastPage' => self::getLastPage(count($reviews), self::ITEM_PER_PAGE),
		]);
	}

	#[Route('/review/{slug}', name: 'app_single_review')]
	public function showReview(Review $review): Response
	{
		return $this->render('review/review.html.twig', compact('review'));
	}
}
