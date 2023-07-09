<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use mysql_xdevapi\TableInsert;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt;

    #[Assert\Count([
        'min' => 2,
        'max' => 2,
        'minMessage' => 'Коллекция должна содержать ровно {{ limit }} изображение',
        'maxMessage' => 'Коллекция должна содержать ровно {{ limit }} изображение',
    ])]
    #[ORM\OneToMany(mappedBy: 'review', targetEntity: Gallery::class, cascade: ['persist', 'remove'])]
    private ?Collection $image;

    #[ORM\Column(length: 255)]
    private ?string $position = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Gallery>
     */
    public function getImage(): ?Collection
    {
        return $this->image;
    }

    public function addImage(Gallery $image): static
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setReview($this);
        }

        return $this;
    }

    public function removeImage(Gallery $image): static
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getReview() === $this) {
                $image->setReview(null);
            }
        }

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }
}
