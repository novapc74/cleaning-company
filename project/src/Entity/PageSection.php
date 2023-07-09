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

    private const WORK_TYPE = 1;
    private const QUESTION_TYPE = 2;
    private const SERVICE_TYPE = 3;

    private const ADVANTAGE_TYPE = 4;

    private const ABOUT_TYPE = 5;
    private const ABOUT_US_TYPE = 6;
    private const CASE_TYPE = 7;

    #[ArrayShape([
		'О нас' => 'integer',
        'Верхний блок "О нас"' => 'integer',
		'Как мы работаем' => 'integer',
		'Вопрос - ответ' => 'integer',
		'Наши услуги' => 'integer',
		'Преимущества' => 'integer',
        'Наши проекты' => 'integer'
	])]
	public static function getAvailableSectionType(): array
	{
		return [
			'О нас' => self::ABOUT_TYPE,
            'Верхний блок "О нас"' => self::ABOUT_US_TYPE,
			'Как мы работаем' => self::WORK_TYPE,
			'Вопрос - ответ' => self::QUESTION_TYPE,
			'Наши услуги' => self::SERVICE_TYPE,
			'Преимущества' => self::ADVANTAGE_TYPE,
            'Наши проекты' => self::CASE_TYPE,
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
