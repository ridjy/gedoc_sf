<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories
{
    /**
     * @var int
     *
     * @ORM\Column(name="cat_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $catId;

    /**
     * @var string
     *
     * @ORM\Column(name="cat_libelle", type="string", length=255, nullable=false)
     */
    private $catLibelle;

    public function getCatId(): ?int
    {
        return $this->catId;
    }

    public function getCatLibelle(): ?string
    {
        return $this->catLibelle;
    }

    public function setCatLibelle(string $catLibelle): self
    {
        $this->catLibelle = $catLibelle;

        return $this;
    }


}
