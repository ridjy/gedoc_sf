<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocMotcle
 *
 * @ORM\Table(name="doc_motcle")
 * @ORM\Entity(repositoryClass="App\Repository\DocMotcleRepository")
 */
class DocMotcle
{
    /**
     * @var int
     *
     * @ORM\Column(name="dmc_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $dmcId;

    /**
     * @var int
     *
     * @ORM\Column(name="doc_id", type="integer", nullable=false)
     */
    private $docId;

    /**
     * @var int
     *
     * @ORM\Column(name="mc_id", type="integer", nullable=false)
     */
    private $mcId;

    /**
     * @var string
     *
     * @ORM\Column(name="date_ajout", type="string", length=255, nullable=false)
     */
    private $dateAjout;

    public function getDmcId(): ?int
    {
        return $this->dmcId;
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

    public function getMcId(): ?int
    {
        return $this->mcId;
    }

    public function setMcId(int $mcId): self
    {
        $this->mcId = $mcId;

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
