<?php

namespace App\Twig;

use App\Entity\Contact;
use App\Repository\ReviewRepository;
use App\Repository\ContactRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Repository\LocationRepository;
use App\Repository\PageSectionRepository;

class AppExtension extends AbstractExtension
{
	public function __construct(private readonly ContactRepository     $contactRepository,
	                            private readonly PageSectionRepository $pageSectionRepository,
	                            private readonly LocationRepository    $locationRepository,
	                            private readonly ReviewRepository      $reviewRepository)
	{
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('contacts', [$this, 'getContacts']),
			new TwigFunction('about', [$this, 'isAbout']),
			new TwigFunction('service', [$this, 'isService']),
			new TwigFunction('work', [$this, 'isWork']),
			new TwigFunction('location', [$this, 'isLocation']),
			new TwigFunction('review', [$this, 'isReview']),
			new TwigFunction('question_answer', [$this, 'isQuestionAnswer']),
			new TwigFunction('case', [$this, 'isCase']),
		];
	}

	public function getContacts(): ?Contact
	{
		return $this->contactRepository->findOneBy([]);
	}

	public function isAbout(): bool
	{
		if ($this->pageSectionRepository->findOneBy(['type' => 6])) {
			return true;
		}

		return false;
	}

	public function isService(): bool
	{
		if ([] !== $this->pageSectionRepository->findBy(['type' => 3])) {
			return true;
		}

		return false;
	}

	public function isWork(): bool
	{
		if ([] !== $this->pageSectionRepository->findBy(['type' => 1])) {
			return true;
		}

		return false;
	}

	public function isLocation(): bool
	{
		{
			if ([] !== $this->locationRepository->findAll()) {
				return true;
			}

			return false;
		}
	}

	public function isReview(): bool
	{
		{
			if ([] !== $this->reviewRepository->findAll()) {
				return true;
			}

			return false;
		}
	}

	public function isQuestionAnswer(): bool
	{
		{
			if ([] !== $this->pageSectionRepository->findBy(['type' => 2])) {
				return true;
			}

			return false;
		}
	}

	public function isCase(): bool
	{
		{
			if ([] !== $this->pageSectionRepository->findBy(['type' => 7])) {
				return true;
			}

			return false;
		}
	}
}