<?php declare(strict_types=1);

namespace App\Model\Contact\Form;
use App\Entity\Contact;

class ContactFormData
{
    private string $name;
    private string $surname;
    private ?string $phone;
    private string $email;
    private ?string $note;

    public function toEntity(): Contact
    {
        return new Contact($this->getName(), $this->getSurname(), $this->getPhone(), $this->getEmail(), $this->getNote());
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote($note)
    {
        $this->note = $note;
    }
}
