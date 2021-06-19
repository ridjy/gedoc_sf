<?php

namespace App\Repository;

use App\Entity\DocCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocCategorie[]    findAll()
 * @method DocCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocCategorie::class);
    }

    // /**
    //  * @return DocCategorie[] Returns an array of DocCategorie objects
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
    public function findOneBySomeField($value): ?DocCategorie
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
