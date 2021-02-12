<?php

namespace App\Entity;

use App\Entity\Team;
use App\Entity\League;
use App\Entity\Highlight;
use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
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
    private $score;

    /**
    * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="teams")
    */
    private $homeTeam;

    /**
    * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="teams")
    */
    private $foreignTeam;

    /**
    * @ORM\OneToMany(targetEntity=Highlight::class, cascade={"persist", "remove"}, mappedBy="game")
    */
    protected $highlights;

    /**
    * @ORM\ManyToOne(targetEntity=League::class, inversedBy="games")
    */
    private $league;

    public function __construct()
    {
        $this->highlights = new ArrayCollection();
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

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(?string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    public function setHomeTeam(Team $homeTeam)
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    public function getForeignTeam()
    {
        return $this->foreignTeam;
    }

    public function setForeignTeam(Team $foreignTeam)
    {
        $this->foreignTeam = $foreignTeam;

        return $this;
    }

    public function getHighlights()
    {
        return $this->highlights;
    }

    public function addHighlight(Highlight $highlight)
    {
        if (!$this->highlights->contains($highlight)) {
            $this->highlights[] = $highlight;
            $highlight->setGame($this);
        }

        return $this;
    }

    public function removeHighlight(Highlight $highlight)
    {
        if ($this->highlights->contains($highlight)) {
            $this->highlights->removeElement($highlight);
            // set the owning side to null (unless already changed)
            if ($highlight->getGame() === $this) {
                $highlight->setGame(null);
            }
        }

        return $this;
    }

    public function getLeague()
    {
        return $this->league;
    }

    public function setLeague(League $league)
    {
        $this->league = $league;

        return $this;
    }
}
