<?php

namespace App\Repository;

use App\Entity\DocMotcle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocMotcle|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocMotcle|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocMotcle[]    findAll()
 * @method DocMotcle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocMotcleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocMotcle::class);
    }

    // /**
    //  * @return DocMotcle[] Returns an array of DocMotcle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DocMotcle
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
