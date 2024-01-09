<?php

namespace App\Model\Contact;

use App\Entity\Contact;
use App\Entity\NotificationAlert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function slugExist(string $slug, ?int $id = null): bool
    {
        $query = $this->createQueryBuilder('c')
            ->select('c.id')
            ->where('c.slug = :slug')->setParameter('slug', $slug);
        if ($id !== null) {
            $query->andWhere('c.id != :id')->setParameter('id', $id);
        }

        return count($query->getQuery()->getResult()) > 0;
    }

    public function save(Contact $entity): void
    {
        $em = $this->getEntityManager();
        $em->persist($entity);
        $em->flush();
    }

    public function remove(Contact $entity): void
    {
        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();
    }
}
