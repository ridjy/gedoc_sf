<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Motcles
 *
 * @ORM\Table(name="motcles", uniqueConstraints={@ORM\UniqueConstraint(name="mc_lib", columns={"mc_lib"})})
 * @ORM\Entity(repositoryClass="App\Repository\MotclesRepository")
 */
class Motcles
{
    /**
     * @var int
     *
     * @ORM\Column(name="mc_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $mcId;

    /**
     * @var string
     *
     * @ORM\Column(name="mc_lib", type="string", length=100, nullable=false)
     */
    private $mcLib;

    public function getMcId(): ?int
    {
        return $this->mcId;
    }

    public function getMcLib(): ?string
    {
        return $this->mcLib;
    }

    public function setMcLib(string $mcLib): self
    {
        $this->mcLib = $mcLib;

        return $this;
    }


}
