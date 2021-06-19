<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocCategorie
 *
 * @ORM\Table(name="doc_categorie")
 * @ORM\Entity(repositoryClass="App\Repository\DocCategorieRepository")
 */
class DocCategorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="doc_id", type="integer", nullable=false)
     */
    private $docId;

    /**
     * @var int
     *
     * @ORM\Column(name="cat_id", type="integer", nullable=false)
     */
    private $catId;

    /**
     * @var string
     *
     * @ORM\Column(name="date_ajout", type="string", length=255, nullable=false)
     */
    private $dateAjout;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocId(): ?int
    {
        return $this->docId;
    }

    public function setDocId(int $docId): self
    {
        $this->docId = $docId;

        return $this;
    }

    public function getCatId(): ?int
    {
        return $this->catId;
    }

    public function setCatId(int $catId): self
    {
        $this->catId = $catId;

        return $this;
    }

    public function getDateAjout(): ?string
    {
        return $this->dateAjout;
    }

    public function setDateAjout(string $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }


}
