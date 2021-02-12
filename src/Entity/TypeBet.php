<?php

namespace App\Entity;

use App\Entity\Bet;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeBetRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=TypeBetRepository::class)
 */
class TypeBet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
    * @ORM\OneToMany(targetEntity=Bet::class, cascade={"persist", "remove"}, mappedBy="typebet")
    */
    protected $bets;

    public function __construct()
    {
        $this->bets = new ArrayCollection();
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

    public function getBets()
    {
        return $this->bets;
    }

    public function addBet(Bet $bet)
    {
        if (!$this->bets->contains($bet)) {
            $this->bets[] = $bet;
            $bet->setTypeBet($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet)
    {
        if ($this->bets->contains($bet)) {
            $this->bets->removeElement($bet);
            // set the owning side to null (unless already changed)
            if ($bet->getTypeBet() === $this) {
                $bet->setTypeBet(null);
            }
        }

        return $this;
    }
}
