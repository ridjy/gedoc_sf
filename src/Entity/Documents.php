<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documents
 *
 * @ORM\Table(name="documents")
 * @ORM\Entity(repositoryClass="App\Repository\DocumentsRepository")
 */
class Documents
{
    /**
     * @var int
     *
     * @ORM\Column(name="doc_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @ORM\Column(name="doc_name", type="string", length=250, nullable=false)
     */
    private $docName;

    /**
     * @var string
     *
     * @ORM\Column(name="doc_date_creation", type="string", length=255, nullable=false)
     */
    private $docDateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="doc_date_modif", type="string", length=255, nullable=false)
     */
    private $docDateModif;

    /**
     * @var string
     *
     * @ORM\Column(name="doc_description", type="text", length=65535, nullable=false)
     */
    private $docDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="doc_emplacement", type="string", length=255, nullable=false)
     */
    private $docEmplacement;

    /**
     * @var int
     *
     * @ORM\Column(name="doc_taille", type="integer", nullable=false)
     */
    private $docTaille;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="doc_titre", type="string", length=250, nullable=true)
     */
    private $docTitre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="doc_date_publication", type="string", length=75, nullable=true)
     */
    private $docDatePublication;

    public function getDocId(): ?int
    {
        return $this->docId;
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

    public function getDocName(): ?string
    {
        return $this->docName;
    }

    public function setDocName(string $docName): self
    {
        $this->docName = $docName;

        return $this;
    }

    public function getDocDateCreation(): ?string
    {
        return $this->docDateCreation;
    }

    public function setDocDateCreation(string $docDateCreation): self
    {
        $this->docDateCreation = $docDateCreation;

        return $this;
    }

    public function getDocDateModif(): ?string
    {
        return $this->docDateModif;
    }

    public function setDocDateModif(string $docDateModif): self
    {
        $this->docDateModif = $docDateModif;

        return $this;
    }

    public function getDocDescription(): ?string
    {
        return $this->docDescription;
    }

    public function setDocDescription(string $docDescription): self
    {
        $this->docDescription = $docDescription;

        return $this;
    }

    public function getDocEmplacement(): ?string
    {
        return $this->docEmplacement;
    }

    public function setDocEmplacement(string $docEmplacement): self
    {
        $this->docEmplacement = $docEmplacement;

        return $this;
    }

    public function getDocTaille(): ?int
    {
        return $this->docTaille;
    }

    public function setDocTaille(int $docTaille): self
    {
        $this->docTaille = $docTaille;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getDocTitre(): ?string
    {
        return $this->docTitre;
    }

    public function setDocTitre(?string $docTitre): self
    {
        $this->docTitre = $docTitre;

        return $this;
    }

    public function getDocDatePublication(): ?string
    {
        return $this->docDatePublication;
    }

    public function setDocDatePublication(?string $docDatePublication): self
    {
        $this->docDatePublication = $docDatePublication;

        return $this;
    }


}
