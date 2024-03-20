<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\ContactMessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactMessageRepository::class)]
#[ApiResource(
    shortName: 'ContactMessage',
    description: 'Obsługa formularza i dane zapisane',
    operations: [
        new GetCollection(
            uriTemplate: '/contact/list',
            shortName: 'Lista wiadomości',
            description: 'Wyświetlanie listy zapisanych danych z formularza'
        ),
        new Post(
            uriTemplate: '/contact/form',
            shortName: 'Formularz przyjmowania wiadomości',
            description: 'Obsługa wysyłki formularza kontaktowego',
        ),
    ],
    formats: ['json' => ['application/json']],
    normalizationContext: ['groups' => ['contact:write']],
    paginationItemsPerPage: 10,
)]
class ContactMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['contact:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Nie wprowadzono imienia i nazwiska')]
    #[Groups(['contact:write'])]
    #[ApiProperty(
        openapiContext: [
            'type' => 'string',
            'example' => 'Randy Orton'
        ]
    )]
    private ?string $fullName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Nie wprowadzono adresu e-mail')]
    #[Assert\Email(message: 'Wprowadzona wartość {{ value }} nie jest poprawnym adresem email')]
    #[Groups(['contact:write'])]
    #[ApiProperty(
        openapiContext: [
            'type' => 'string',
            'example' => 'rko@wwe.com'
        ]
    )]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Nie wprowadzono treści wiadomości')]
    #[Groups(['contact:write'])]
    #[ApiProperty(
        openapiContext: [
            'type' => 'string',
            'example' => 'The Apex Predator'
        ]
    )]
    private ?string $message = null;

    #[ORM\Column]
    #[Assert\IsTrue(message: 'Brak zgody na przetwarzanie danych')]
    #[Groups(['contact:write'])]
    #[ApiProperty(
        openapiContext: [
            'type' => 'boolean',
            'example' => true
        ]
    )]
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
