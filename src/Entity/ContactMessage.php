<?php

namespace App\Entity;

use App\Repository\ContactMessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#use OpenApi\Attributes as OA;

#[ORM\Entity(repositoryClass: ContactMessageRepository::class)]
class ContactMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Nie wprowadzono imienia i nazwiska')]
    ##[OA\Property(description: 'Imię i nazwisko', type: 'string', maxLength: 255)]
    private ?string $fullName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Nie wprowadzono adresu e-mail')]
    #[Assert\Email(message: 'Wprowadzona wartość {{ value }} nie jest poprawnym adresem email')]
    ##[OA\Property(description: 'Email', type: 'string', maxLength: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Nie wprowadzono treści wiadomości')]
    ##[OA\Property(description: 'Treść wiadomości', type: 'string')]
    private ?string $message = null;

    #[ORM\Column]
    #[Assert\IsTrue(message: 'Brak zgody na przetwarzanie danych')]
    ##[OA\Property(description: 'Zgoda na przetwarzanie danych osobowych', type: 'boolean')]
    private ?bool $consent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function isConsent(): ?bool
    {
        return $this->consent;
    }

    public function setConsent(bool $consent): static
    {
        $this->consent = $consent;

        return $this;
    }
}
