<?php

namespace App\Model;

use App\Entity\ParameterValue;
use App\Entity\Product;
use App\Entity\ProductParameter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

class ProductParameterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductParameter::class);
    }

    public function xxx2(ParameterValue $parameterValue): array
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('pp')
            ->from(ProductParameter::class, 'pp');
            //->leftJoin(Product::class, 'p', Join::WITH, 'pp.product = p')
            //->where('pp.parameterValue = :parameterValue')->setParameter('parameterValue', $parameterValue);

        return $qb->getQuery()->getResult();
    }
}
