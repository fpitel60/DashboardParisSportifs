<?php

namespace App\Entity;

use App\Repository\BookmakerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookmakerRepository::class)
 */
class Bookmaker
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $outside;

    /**
    * @ORM\OneToMany(targetEntity=BetTest::class, cascade={"persist", "remove"}, mappedBy="bookmaker")
    */
    protected $betstest;

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

    public function getOutside(): ?string
    {
        return $this->outside;
    }

    public function setOutside(string $outside): self
    {
        $this->outside = $outside;

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
}
