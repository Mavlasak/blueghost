<?php

namespace App\Entity;

use App\Model\Contact\ContactRepository;
use App\Model\ProductParameterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductParameterRepository::class)]
class ProductParameter
{
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'productParameter')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private Product|null $product = null;

    #[ORM\ManyToOne(targetEntity: ParameterValue::class, inversedBy: 'parameterValue')]
    #[ORM\JoinColumn(name: 'parameter_value_id', referencedColumnName: 'id')]
    private ParameterValue|null $parameterValue = null;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    public function getParameterValue(): ?ParameterValue
    {
        return $this->parameterValue;
    }

    public function setParameterValue(?ParameterValue $parameterValue): void
    {
        $this->parameterValue = $parameterValue;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }


}
