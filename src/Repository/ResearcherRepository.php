<?php

namespace App\Repository;

use App\Entity\Researcher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Researcher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Researcher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Researcher[]    findAll()
 * @method Researcher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResearcherRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Researcher::class);
    }

    // /**
    //  * @return Researcher[] Returns an array of Researcher objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Researcher
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
