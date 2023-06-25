<?php

namespace App\Entity;

use App\Repository\FeedBackRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;

#[ORM\Entity(repositoryClass: FeedBackRepository::class)]
class FeedBack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $connectionType;

    #[ORM\Column(length: 20)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?bool $isDelivered;

    private const PHONE_TYPE = 0;
    private const EMAIL_TYPE = 1;

    #[ArrayShape(['по телефону' => 'integer', 'по email' => 'integer'])]
    public static function getAvailableConnectionType(): array
    {
        return [
            'по телефону' => self::PHONE_TYPE,
            'по email' => self::EMAIL_TYPE,
        ];
    }

    public function __construct()
    {
        $this->connectionType = 0;
        $this->isDelivered = false;
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

    public function isConnectionType(): ?bool
    {
        return $this->connectionType;
    }

    public function setConnectionType(?bool $connectionType): static
    {
        $this->connectionType = $connectionType;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getIsDelivered(): ?bool
    {
        return $this->isDelivered;
    }

    public function setIsDelivered(bool $isDelivered): static
    {
        $this->isDelivered = $isDelivered;

        return $this;
    }
}
