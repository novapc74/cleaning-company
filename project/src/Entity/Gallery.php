<?php

namespace App\Entity;

use JetBrains\PhpStorm\ArrayShape;
use App\Repository\GalleryRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: GalleryRepository::class)]
#[Vich\Uploadable]
class Gallery
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(nullable: true)]
	private ?int $type = 0;

	#[ORM\ManyToOne(targetEntity: Media::class, cascade: ['persist'])]
	private ?Media $image = null;

	#[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'gallery')]
	private ?PageSection $pageSection = null;

	private const DEFAULT_TYPE = 0;
	private const ABOUT_PAGE_TYPE = 1;

	#[ArrayShape([
		'по умолчанию' => 'integer',
		'о нас' => 'integer',
	])]
	public static function getAvailableGalleryType(): array
	{
		return [
			'по умолчанию' => self::DEFAULT_TYPE,
			'о нас' => self::ABOUT_PAGE_TYPE,
		];
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getType(): ?int
	{
		return $this->type;
	}

	public function setType(int $type): static
	{
		$this->type = $type;

		return $this;
	}

	public function getImage(): ?Media
	{
		return $this->image;
	}

	public function setImage(?Media $image): static
	{
		$this->image = $image;

		return $this;
	}

	public function getPageSection(): ?PageSection
	{
		return $this->pageSection;
	}

	public function setPageSection(?PageSection $pageSection): static
	{
		$this->pageSection = $pageSection;

		return $this;
	}

	public function __toString(): string
	{
		return $this->type ?? $this->id;	// TODO: Implement __toString() method.
	}
}
