<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\TypeByBetHighlight;
use App\Repository\TypeBetHighlightRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=TypeBetHighlightRepository::class)
 */
class TypeBetHighlight
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

    /**
    * @ORM\OneToMany(targetEntity=TypeByBetHighlight::class, cascade={"persist", "remove"}, mappedBy="typeBetHighlight")
    */
    protected $typesByBetHighlight;

    public function __construct()
    {
        $this->typesByBetHighlight = new ArrayCollection();
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

    public function getSport()
    {
        return $this->sport;
    }
 
    public function setSport($sport)
    {
        $this->sport = $sport;
 
        return $this;
    }

    public function getTypesByBetHighlight()
    {
        return $this->typesByBetHighlight;
    }

    public function setTypesByBetHighlight($typesByBetHighlight)
    {
        $this->typesByBetHighlight = $typesByBetHighlight;
        return $this;
    }
     
    public function addTypesByBetHighlight(TypeByBetHighlight $typeByBetHighlight)
    {
        if (!$this->typesByBetHighlight->contains($typeByBetHighlight)) {
            $this->typesByBetHighlight[] = $typeByBetHighlight;
            $typeByBetHighlight->setTypeBetHighlight($this);
        }

        return $this;
    }
}
