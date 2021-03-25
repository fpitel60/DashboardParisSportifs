<?php

namespace App\Entity;

use App\Entity\Sport;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeBetFinalRepository;

/**
 * @ORM\Entity(repositoryClass=TypeBetFinalRepository::class)
 */
class TypeBetFinal
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
    * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="typesBetHighlight")
    */
    protected $sport;

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

    public function getSport()
    {
        return $this->sport;
    }
 
    public function setSport($sport)
    {
        $this->sport = $sport;
 
        return $this;
    }
}
