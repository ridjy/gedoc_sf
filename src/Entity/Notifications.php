<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notifications
 *
 * @ORM\Table(name="notifications")
 * @ORM\Entity(repositoryClass="App\Repository\NotificationsRepository")
 */
class Notifications
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_notif", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNotif;

    /**
     * @var string
     *
     * @ORM\Column(name="date_notif", type="string", length=50, nullable=false)
     */
    private $dateNotif;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var int
     *
     * @ORM\Column(name="lu", type="integer", nullable=false)
     */
    private $lu = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="date_lecture", type="string", length=50, nullable=true)
     */
    private $dateLecture;

    public function getIdNotif(): ?int
    {
        return $this->idNotif;
    }

    public function getDateNotif(): ?string
    {
        return $this->dateNotif;
    }

    public function setDateNotif(string $dateNotif): self
    {
        $this->dateNotif = $dateNotif;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getLu(): ?int
    {
        return $this->lu;
    }

    public function setLu(int $lu): self
    {
        $this->lu = $lu;

        return $this;
    }

    public function getDateLecture(): ?string
    {
        return $this->dateLecture;
    }

    public function setDateLecture(?string $dateLecture): self
    {
        $this->dateLecture = $dateLecture;

        return $this;
    }


}
