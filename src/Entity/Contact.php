<?php

namespace App\Entity;

use App\Model\Contact\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, nullable: false)]
    private string $name;

    #[ORM\Column(name: 'surname', type: Types::STRING, nullable: false)]
    private string $surname;

    #[ORM\Column(name: 'phone', type: Types::STRING, nullable: true)]
    private ?string $phone;

    #[ORM\Column(name: 'email', type: Types::STRING, nullable: false)]
    private string $email;

    #[ORM\Column(name: 'slug', type: Types::STRING, nullable: false)]
    private string $slug;

    #[ORM\Column(name: 'note', type: Types::TEXT, nullable: false)]
    private ?string $note;

    public function __construct(string $name, string $surname, ?string $phone, string $email, ?string $note)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->phone = $phone;
        $this->email = $email;
        $this->note = $note;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }
}
