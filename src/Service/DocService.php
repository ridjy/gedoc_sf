<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Documents;
use App\Entity\DocCategories;

class DocService
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;   
    }

    public function renderDocCategories($n_idDoc)
    {
        $entity_manager = $this->em;
        $a_allCategorie = $entity_manager->getRepository(Documents::class)->findAllCategorieofDocs($n_idDoc);
        $retour = '';
        foreach ($a_allCategorie as $categorie) {
            $retour .= " <span class='label label-primary' style='font-size:11px;'>{$categorie['cat_libelle']}</span> ";
        }
        return $retour;
    }//fin get categories

    public function renderDocMotcle($n_idDoc)
    {
        $entity_manager = $this->em;
        $a_allMC = $entity_manager->getRepository(Documents::class)->findAllKeywordOfDocs($n_idDoc);
        $retour = '';
        foreach ($a_allMC as $mc) {
            $retour .= " <span class='label label-success' style='font-size:11px;'>{$mc['mc_lib']}</span> ";
        }
        return $retour;
    }//fin get categories

}//fin class
