<?php

namespace App\Repository;

use App\Entity\Documents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Documents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Documents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Documents[]    findAll()
 * @method Documents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Documents::class);
    }

    //get all categorie of the docs
    public function findAllCategorieofDocs($n_idDoc)
    {
        $s_sql = "SELECT c.cat_libelle FROM categories c INNER JOIN doc_categorie dc ON dc.cat_id=c.cat_id 
        WHERE dc.doc_id={$n_idDoc}";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($s_sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }//fin findall

    //get all Keyword of the docs
    public function findAllKeywordOfDocs($n_idDoc)
    {
        $s_sql = "SELECT mc.mc_lib FROM motcles mc INNER JOIN doc_motcle dc USING(mc_id) 
        WHERE dc.doc_id={$n_idDoc}";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($s_sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }//fin findall

    //delete all Keyword of the docs
    public function deleteAllKeywordOfDocs($n_idDoc)
    {
        $s_sql = "DELETE FROM doc_motcle WHERE doc_id={$n_idDoc}";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($s_sql);
        $stmt->execute();
        return true;
    }//fin findall

    //get all categorie of the docs
    public function deleteAllCategorieofDocs($n_idDoc)
    {
        $s_sql = "DELETE FROM doc_categorie WHERE doc_id={$n_idDoc}";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($s_sql);
        $stmt->execute();
        return true;
    }//fin findall


}//fin
