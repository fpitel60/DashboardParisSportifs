<?php

namespace App\Entity;

use App\Repository\BetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BetRepository::class)
 */
class Bet
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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $resultBet;

    /**
    * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bets")
    */
    protected $user;

    /**
    * @ORM\ManyToOne(targetEntity=TypeBet::class, inversedBy="bets")
    */
    protected $typebet;

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

    public function getResultBet(): ?bool
    {
        return $this->resultBet;
    }

    public function setResultBet(?bool $resultBet): self
    {
        $this->resultBet = $resultBet;

        return $this;
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

    public function getTypeBet()
    {
        return $this->typebet;
    }
 
    public function setTypeBet($typebet)
    {
        $this->typebet = $typebet;
 
        return $this;
    }
}
