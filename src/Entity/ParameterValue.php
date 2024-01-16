<?php

namespace App\Entity;

use App\Model\Contact\ContactRepository;
use App\Model\ParameterValueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParameterValueRepository::class)]
class ParameterValue
{
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(name: 'value', type: Types::STRING, nullable: false)]
    private string $value;

    #[ORM\ManyToOne(targetEntity: Parameter::class, inversedBy: 'parameterValue')]
    #[ORM\JoinColumn(name: 'parameter_id', referencedColumnName: 'id')]
    private Parameter|null $parameter = null;

    #[ORM\OneToMany(targetEntity: ProductParameter::class, mappedBy: 'parameterValue')]
    private Collection $productParameter;

    public function __construct() {
        $this->productParameter = new ArrayCollection();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getParameter(): ?Parameter
    {
        return $this->parameter;
    }

    public function setParameter(?Parameter $parameter): void
    {
        $this->parameter = $parameter;
    }

    public function getProductParameter(): Collection
    {
        return $this->productParameter;
    }

    public function setProductParameter(Collection $productParameter): void
    {
        $this->productParameter = $productParameter;
    }


}
