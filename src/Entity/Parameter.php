<?php

namespace App\Entity;

use App\Model\Contact\ContactRepository;
use App\Model\ParameterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParameterRepository::class)]
class Parameter
{
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, nullable: false)]
    private string $name;

    #[ORM\OneToMany(targetEntity: ParameterValue::class, mappedBy: 'parameter')]
    private Collection $parameterValue;

    public function __construct() {
        $this->parameterValue = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getParameterValue(): Collection
    {
        return $this->parameterValue;
    }

    public function setParameterValue(Collection $parameterValue): void
    {
        $this->parameterValue = $parameterValue;
    }


}
