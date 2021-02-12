<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 */
class Sport
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
    * @ORM\OneToMany(targetEntity=League::class, cascade={"persist", "remove"}, mappedBy="sport")
    */
    protected $leagues;

    /**
    * @ORM\OneToMany(targetEntity=TypeHighlight::class, cascade={"persist", "remove"}, mappedBy="sport")
    */
    protected $typehighlights;

    public function __construct()
    {
        $this->leagues = new ArrayCollection();
        $this->typehighlights = new ArrayCollection();
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

    public function getLeagues()
    {
        return $this->leagues;
    }
     
    public function addLeague(League $league)
    {
        if (!$this->leagues->contains($league)) {
            $this->leagues[] = $league;
            $league->setSport($this);
        }

        return $this;
    }

    public function removeLeague(League $league)
    {
        if ($this->leagues->contains($league)) {
            $this->leagues->removeElement($league);
            // set the owning side to null (unless already changed)
            if ($league->getSport() === $this) {
                $league->setSport(null);
            }
        }

        return $this;
    }

    public function getTypeHighlights()
    {
        return $this->typeHighlights;
    }

    public function addTypeHighlight(TypeHighlight $typeHighlight)
    {
        if (!$this->typeHighlights->contains($typeHighlight)) {
            $this->typeHighlights[] = $typeHighlight;
            $typeHighlight->setSport($this);
        }

        return $this;
    }

    public function removeTypeHighlight(League $typeHighlight)
    {
        if ($this->typeHighlights->contains($typeHighlight)) {
            $this->typeHighlights->removeElement($typeHighlight);
            // set the owning side to null (unless already changed)
            if ($typeHighlight->getSport() === $this) {
                $typeHighlight->setSport(null);
            }
        }

        return $this;
    }
}
