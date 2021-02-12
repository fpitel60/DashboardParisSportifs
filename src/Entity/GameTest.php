<?php

namespace App\Entity;

use App\Entity\BetTest;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GameTestRepository;

/**
 * @ORM\Entity(repositoryClass=GameTestRepository::class)
 */
class GameTest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $choix;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cote;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resultBet;

    /**
    * @ORM\ManyToOne(targetEntity=BetTest::class, inversedBy="gamestest")
    */
    protected $bettest;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getChoix(): ?string
    {
        return $this->choix;
    }

    public function setChoix(string $choix): self
    {
        $this->choix = $choix;

        return $this;
    }

    public function getCote(): ?float
    {
        return $this->cote;
    }

    public function setCote(float $cote): self
    {
        $this->cote = $cote;

        return $this;
    }

    public function getResultBet(): ?string
    {
        return $this->resultBet;
    }

    public function setResultBet(?string $resultBet): self
    {
        $this->resultBet = $resultBet;

        return $this;
    }

    public function getBetTest()
    {
        return $this->bettest;
    }

    public function setBetTest(BetTest $bettest)
    {
        $this->bettest = $bettest;

        return $this;
    }
}
