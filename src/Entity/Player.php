<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
    * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="players")
    */
    private $team;

    /**
    * @ORM\OneToMany(targetEntity=Highlight::class, cascade={"persist", "remove"}, mappedBy="player")
    */
    protected $highlights;

    public function __construct()
    {
        $this->highlights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    public function getHighlights(): Collection
    {
        return $this->highlights;
    }

    public function addHighlight(Highlight $highlight): self
    {
        if (!$this->highlights->contains($highlight)) {
            $this->highlights[] = $highlight;
            $highlight->setPlayer($this);
        }

        return $this;
    }

    public function removeHighlight(Highlight $highlight): self
    {
        if ($this->highlights->contains($highlight)) {
            $this->highlights->removeElement($highlight);
            // set the owning side to null (unless already changed)
            if ($highlight->getPlayer() === $this) {
                $highlight->setPlayer(null);
            }
        }

        return $this;
    }
}
