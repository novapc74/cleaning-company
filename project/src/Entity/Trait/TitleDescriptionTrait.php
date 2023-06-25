<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait TitleDescriptionTrait {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	public function getId(): ?int
	{
		return $this->id;
	}
}
