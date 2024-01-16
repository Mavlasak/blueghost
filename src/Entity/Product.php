<?php

namespace App\Entity;

use App\Model\Contact\ContactRepository;
use App\Model\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, nullable: false)]
    private string $name;

    #[ORM\OneToMany(targetEntity: ProductParameter::class, mappedBy: 'product')]
    private Collection $productParameter;

    public function __construct() {
        $this->productParameter = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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
