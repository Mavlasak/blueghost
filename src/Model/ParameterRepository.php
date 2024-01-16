<?php

namespace App\Model;

use App\Entity\Parameter;
use App\Entity\ParameterValue;
use App\Entity\PensionSavingChapter;
use App\Entity\PensionSavingQuestion;
use App\Entity\Product;
use App\Entity\ProductParameter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

class ParameterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parameter::class);
    }

    public function xxx(): array
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('COUNT(pp.product) AS productCount, pv')
            ->from(ProductParameter::class, 'pp')
            ->leftJoin(ParameterValue::class, 'pv', Join::WITH, 'pp.parameterValue = pv')
            ->groupBy('pv')
            ->orderBy('pv.parameter');

        return $qb->getQuery()->getResult();
    }

    public function xxx3(ParameterValue $parameterValue): array
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p.id')
            ->from(ProductParameter::class, 'pp')
            ->leftJoin(ParameterValue::class, 'pv', Join::WITH, 'pp.parameterValue = pv')
            ->leftJoin(Product::class, 'p', Join::WITH, 'pp.product = p')
            ->where('pp.parameterValue = :parameterValue')->setParameter('parameterValue', $parameterValue)
            ->groupBy('p')
            ->orderBy('pv.parameter');

        $productIds = $qb->getQuery()->getSingleColumnResult();
        //dd($productIds);
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('COUNT(pp.product) AS productCount, pv')
            ->from(ProductParameter::class, 'pp')
            ->leftJoin(ParameterValue::class, 'pv', Join::WITH, 'pp.parameterValue = pv')
            ->leftJoin(Parameter::class, 'p', Join::WITH, 'pv.parameter = p')
            ->where('p != :parameter')->setParameter('parameter', $parameterValue->getParameter())
            ->andWhere('pp.product IN (:ids)')->setParameter('ids', $productIds)
            ->groupBy('pv')
            ->orderBy('pv.parameter');

        dd($qb->getQuery()->getResult());
    }
}
