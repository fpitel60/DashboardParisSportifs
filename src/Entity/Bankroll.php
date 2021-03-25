<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BankrollRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=BankrollRepository::class)
 */
class Bankroll
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $visibility;

    /**
     * @ORM\Column(type="float")
     */
    private $startBankroll;

    /**
     * @ORM\Column(type="float")
     */
    private $currentBankroll;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $misesCumul;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $benefsCumul;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $roi;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $roc;

    /**
    * @ORM\OneToMany(targetEntity=BetTest::class, cascade={"persist", "remove"}, mappedBy="user")
    */
    protected $betstest;

    /**
    * @ORM\OneToMany(targetEntity=Montante::class, cascade={"persist", "remove"}, mappedBy="bankroll")
    */
    protected $montantes;

    /**
    * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bankrolls")
    */
    protected $user;

    public function __construct()
    {
        $this->betstest = new ArrayCollection();
        $this->montante = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    public function setVisibility(string $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getStartBankroll(): ?float
    {
        return $this->startBankroll;
    }

    public function setStartBankroll(float $startBankroll): self
    {
        $this->startBankroll = $startBankroll;

        return $this;
    }

    public function getCurrentBankroll(): ?float
    {
        return $this->currentBankroll;
    }

    public function setCurrentBankroll(float $currentBankroll): self
    {
        $this->currentBankroll = $currentBankroll;

        return $this;
    }

    public function getMisesCumul(): ?float
    {
        return $this->misesCumul;
    }

    public function setMisesCumul(float $misesCumul): self
    {
        $this->misesCumul = $misesCumul;

        return $this;
    }

    public function getBenefsCumul(): ?float
    {
        return $this->benefsCumul;
    }

    public function setBenefsCumul(?float $benefsCumul): self
    {
        $this->benefsCumul = $benefsCumul;

        return $this;
    }

    public function getRoi(): ?float
    {
        return $this->roi;
    }

    public function setRoi(?float $roi): self
    {
        $this->roi = $roi;

        return $this;
    }

    public function getRoc(): ?float
    {
        return $this->roc;
    }

    public function setRoc(?float $roc): self
    {
        $this->roc = $roc;

        return $this;
    }

    public function getBetsTest()
    {
        return $this->betstest;
    }
     
    public function addBetTest(Bet $bettest)
    {
        $this->betstest->add($bettest);
        $bettest->setUser($this);
    }

    public function getMontantes()
    {
        return $this->montantes;
    }
     
    public function addMontante(Montante $montante)
    {
        $this->montantes->add($montante);
        $montante->setBankroll($this);
    }

    public function getUser()
    {
        return $this->user;
    }
 
    public function setUser($user)
    {
        $this->user = $user;
 
        return $this;
    }
}
