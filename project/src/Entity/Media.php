<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[Vich\Uploadable]
class Media
{
	#[ORM\Id]
	#[ORM\Column]
	#[ORM\GeneratedValue]
	private ?int $id = null;

	#[Vich\UploadableField(mapping: 'media', fileNameProperty: 'imageName', size: 'imageSize', mimeType: 'mimeType')]
	private ?File $imageFile = null;

	#[ORM\Column(nullable: true)]
	private ?string $imageName = null;

	#[ORM\Column(nullable: true)]
	private ?int $imageSize = null;

	#[ORM\Column(length: 40, nullable: true)]
	private ?string $mimeType = null;

	#[ORM\Column(nullable: true)]
	private ?DateTimeImmutable $updatedAt = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	/**
	 * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
	 * of 'UploadedFile' is injected into this setter to trigger the update. If this
	 * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
	 * must be able to accept an instance of 'File' as the bundle will inject one here
	 * during Doctrine hydration.
	 *
	 * @param File|null $imageFile
	 */
	public function setImageFile(?File $imageFile = null): void
	{
		$this->imageFile = $imageFile;

		if (null !== $imageFile) {
			$this->updatedAt = new DateTimeImmutable();
		}
	}

	public function getImageFile(): ?File
	{
		return $this->imageFile;
	}

	public function setImageName(?string $imageName): void
	{
		$this->imageName = $imageName;
	}

	public function getImageName(): ?string
	{
		return $this->imageName;
	}

	public function setImageSize(?int $imageSize): void
	{
		$this->imageSize = $imageSize;
	}

	public function getImageSize(): ?int
	{
		return $this->imageSize;
	}

	public function getMimeType(): ?string
	{
		return $this->mimeType;
	}

	public function setMimeType(?string $mimeType): static
	{
		$this->mimeType = $mimeType;

		return $this;
	}

	public function __toString(): string
	{
		return $this->imageName ?? 'image';    // TODO: Implement __toString() method.
	}
}
