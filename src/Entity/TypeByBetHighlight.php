<?php

namespace App\Entity;

use App\Repository\TypeByBetHighlightRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeByBetHighlightRepository::class)
 */
class TypeByBetHighlight
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
    * @ORM\ManyToOne(targetEntity=TypeBetHighlight::class, inversedBy="typesByBetHighlight")
    */
    protected $typeBetHighlight;

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

    public function getTypeBetHighlight()
    {
        return $this->typeBetHighlight;
    }

    public function setTypeBetHighlight($typeBetHighlight)
    {
        $this->typeBetHighlight = $typeBetHighlight;
        return $this;
    }
}
