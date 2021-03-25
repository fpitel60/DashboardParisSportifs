<?php

namespace App\Entity;

use App\Entity\PalierMontante;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MontanteRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=MontanteRepository::class)
 */
class Montante
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPalier;

    /**
     * @ORM\Column(type="integer")
     */
    private $miseStart;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $objectif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resultMontante;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $gain;

    /**
    * @ORM\OneToMany(targetEntity=PalierMontante::class, cascade={"persist", "remove"}, mappedBy="montante")
    */
    protected $paliersMontante;

    /**
    * @ORM\ManyToOne(targetEntity=Bankroll::class, inversedBy="montantes")
    */
    protected $bankroll;

    public function __construct()
    {
        $this->paliersMontante = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getNbPalier(): ?int
    {
        return $this->nbPalier;
    }

    public function setNbPalier(int $nbPalier): self
    {
        $this->nbPalier = $nbPalier;

        return $this;
    }

    public function getMiseStart(): ?int
    {
        return $this->miseStart;
    }

    public function setMiseStart(int $miseStart): self
    {
        $this->miseStart = $miseStart;

        return $this;
    }

    public function getObjectif(): ?int
    {
        return $this->objectif;
    }

    public function setObjectif(?int $objectif): self
    {
        $this->objectif = $objectif;

        return $this;
    }

    public function getResultMontante(): ?string
    {
        return $this->resultMontante;
    }

    public function setResultMontante(?string $resultMontante): self
    {
        $this->resultMontante = $resultMontante;

        return $this;
    }

    public function getGain(): ?float
    {
        return $this->gain;
    }

    public function setGain($gain): self
    {
        $this->gain = $gain;

        return $this;
    }

    public function getPaliersMontante()
    {
        return $this->paliersMontante;
    }

    public function setPaliersMontante($paliersMontante)
    {
        $this->paliersMontante = $paliersMontante;
        return $this;
    }
     
    public function addPalierMontante(PalierMontante $palierMontante)
    {
        if (!$this->paliersMontante->contains($palierMontante)) {
            $this->paliersMontante[] = $palierMontante;
            $palierMontante->setMontante($this);
        }

        return $this;
    }

    public function getBankroll()
    {
        return $this->bankroll;
    }
 
    public function setBankroll($bankroll)
    {
        $this->bankroll = $bankroll;
 
        return $this;
    }
}
