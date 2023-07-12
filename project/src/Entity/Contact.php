<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 20)]
	private ?string $phone = null;

	#[ORM\Column(length: 255)]
	private ?string $email = null;

	#[ORM\Column(type: Types::TEXT)]
	private ?string $address = null;

	#[ORM\OneToMany(mappedBy: 'contact', targetEntity: Social::class)]
	private Collection $socials;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $link = null;

	public function __construct()
	{
		$this->socials = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getPhone(): ?string
	{
		return $this->phone;
	}

	public function setPhone(string $phone): static
	{
		$this->phone = $phone;

		return $this;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(string $email): static
	{
		$this->email = $email;

		return $this;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function setAddress(string $address): static
	{
		$this->address = $address;

		return $this;
	}

	/**
	 * @return Collection<int, Social>
	 */
	public function getSocials(): Collection
	{
		return $this->socials;
	}

	public function addSocial(Social $social): static
	{
		if (!$this->socials->contains($social)) {
			$this->socials->add($social);
			$social->setContact($this);
		}

		return $this;
	}

	public function removeSocial(Social $social): static
	{
		if ($this->socials->removeElement($social)) {
			// set the owning side to null (unless already changed)
			if ($social->getContact() === $this) {
				$social->setContact(null);
			}
		}

		return $this;
	}

	public function explodeAddress(): array
	{
		return explode("\r\n\r\n", $this->address);
	}

	public function getLink(): ?string
	{
		return $this->link;
	}

	public function setLink(?string $link): static
	{
		$this->link = $link;

		return $this;
	}

	public function getNumericPhone(): string
	{
		$replaceChars = ['+', '(', ')', ' ', '-'];

		return str_replace($replaceChars, '', $this->phone);
	}
}
