<?php

namespace App\Entity;

use JetBrains\PhpStorm\ArrayShape;
use App\Repository\PageSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageSectionRepository::class)]
class PageSection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'pageSection', targetEntity: Gallery::class, cascade: ['persist', 'remove'])]
    private Collection $gallery;

    #[ORM\Column(nullable: false)]
    private ?string $type = null;

	private const ABOUT_TYPE = 0;
	private const WORK_TYPE = 1;
	private const QUESTION_TYPE = 2;

	#[ArrayShape([
		'о нас' => 'integer',
		'как это работает' => 'integer',
		'вопрос - ответ' => 'integer',
	])]
	public static function getAvailableSectionType(): array
	{
		return [
			'о нас' => self::ABOUT_TYPE,
			'как это работает' => self::WORK_TYPE,
			'вопрос - ответ' => self::QUESTION_TYPE,
		];
	}
    public function __construct()
    {
        $this->gallery = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Gallery>
     */
    public function getGallery(): Collection
    {
        return $this->gallery;
    }

    public function addGallery(Gallery $gallery): static
    {
        if (!$this->gallery->contains($gallery)) {
            $this->gallery->add($gallery);
            $gallery->setPageSection($this);
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): static
    {
        if ($this->gallery->removeElement($gallery)) {
            // set the owning side to null (unless already changed)
            if ($gallery->getPageSection() === $this) {
                $gallery->setPageSection(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
