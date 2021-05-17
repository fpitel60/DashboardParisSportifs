<?php

namespace App\Entity;

use App\Entity\GameTest;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BetTestRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=BetTestRepository::class)
 */
class BetTest
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
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resultBet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeBet;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cote;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $mise;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $gain;

    /**
    * @ORM\ManyToOne(targetEntity=Bankroll::class, inversedBy="betstest")
    */
    protected $bankroll;

    /**
    * @ORM\ManyToOne(targetEntity=Bookmaker::class, inversedBy="betstest")
    */
    protected $bookmaker;

    /**
     * @ORM\Column(type="integer")
     */
    private $week;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
    * @ORM\OneToMany(targetEntity=GameTest::class, cascade={"persist", "remove"}, mappedBy="bettest")
    */
    protected $gamestest;

    /**
    * @ORM\OneToOne(targetEntity=PalierMontante::class, cascade={"persist", "remove"}, inversedBy="betTest")
    * @ORM\JoinColumn(name="palier_montante_id", referencedColumnName="id", nullable=true)
    */
    protected $palierMontante;

    public function __construct()
    {
        $this->gamestest = new ArrayCollection();
    }

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

    public function getResultBet(): ?string
    {
        return $this->resultBet;
    }

    public function setResultBet(?string $resultBet): self
    {
        $this->resultBet = $resultBet;

        return $this;
    }

    public function getTypeBet(): ?string
    {
        return $this->typeBet;
    }

    public function setTypeBet(?string $typeBet): self
    {
        $this->typeBet = $typeBet;

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

    public function getMise(): ?float
    {
        return $this->mise;
    }

    public function setMise(float $mise): self
    {
        $this->mise = $mise;

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

    public function getBankroll()
    {
        return $this->bankroll;
    }
 
    public function setBankroll($bankroll)
    {
        $this->bankroll = $bankroll;
 
        return $this;
    }

    public function getBookmaker()
    {
        return $this->bookmaker;
    }
 
    public function setBookmaker($bookmaker)
    {
        $this->bookmaker = $bookmaker;
 
        return $this;
    }

    public function getWeek()
    {
        return $this->week;
    }
 
    public function setWeek($week)
    {
        $this->week = $week;
 
        return $this;
    }

    public function getYear()
    {
        return $this->year;
    }
 
    public function setYear($year)
    {
        $this->year = $year;
 
        return $this;
    }

    public function getGamesTest()
    {
        return $this->gamestest;
    }

    public function setGamesTest($gamestest)
    {
        $this->gamestest = $gamestest;
        return $this;
    }
     
    public function addGame(GameTest $gametest)
    {
        if (!$this->gamestest->contains($gametest)) {
            $this->gamestest[] = $gametest;
            $gametest->setBetTest($this);
        }

        return $this;
    }

    public function getPalierMontante()
    {
        return $this->palierMontante;
    }
 
    public function setPalierMontante($palierMontante)
    {
        $this->palierMontante = $palierMontante;
 
        return $this;
    }
}
