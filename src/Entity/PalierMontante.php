<?php

namespace App\Entity;

use App\Entity\BetTest;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PalierMontanteRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=PalierMontanteRepository::class)
 */
class PalierMontante
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberPalier;

    /**
    * @ORM\ManyToOne(targetEntity=Montante::class, inversedBy="paliersMontante")
    */
    protected $montante;

    /**
    * @ORM\OneToOne(targetEntity=BetTest::class, cascade={"remove"}, mappedBy="palierMontante")
    * @ORM\JoinColumn(name="bet_test_id", referencedColumnName="id", nullable=true)
    */
    protected $betTest;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberPalier(): ?int
    {
        return $this->numberPalier;
    }

    public function setNumberPalier(int $numberPalier): self
    {
        $this->numberPalier = $numberPalier;

        return $this;
    }

    public function getMontante()
    {
        return $this->montante;
    }

    public function setMontante($montante): self
    {
        $this->montante = $montante;

        return $this;
    }

    public function getBetTest()
    {
        return $this->betTest;
    }

    public function setBetTest($betTest)
    {
        $this->betTest = $betTest;
        return $this;
    }
}
