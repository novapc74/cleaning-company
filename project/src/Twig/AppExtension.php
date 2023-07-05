<?php

namespace App\Twig;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(private readonly ContactRepository $contactRepository)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('contacts', [$this, 'getContacts']),
        ];
    }

    public function getContacts(): ?Contact
    {
        return $this->contactRepository->findOneBy([]);
    }
}