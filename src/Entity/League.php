<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LeagueRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=LeagueRepository::class)
 */
class League
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
    * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="leagues")
    */
    private $sport;

    /**
    * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="leagues")
    */
    private $country;

    /**
    * @ORM\OneToMany(targetEntity=Team::class, cascade={"persist", "remove"}, mappedBy="league")
    */
    protected $teams;

    /**
    * @ORM\OneToMany(targetEntity=Game::class, cascade={"persist", "remove"}, mappedBy="league")
    */
    protected $games;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->games = new ArrayCollection();
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

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    public function getTeams()
    {
        return $this->teams;
    }

    public function addTeam(Team $team)
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setLeague($this);
        }

        return $this;
    }

    public function removeTeam(Team $team)
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            // set the owning side to null (unless already changed)
            if ($team->getLeague() === $this) {
                $team->setLeague(null);
            }
        }

        return $this;
    }

    public function getGames()
    {
        return $this->games;
    }

    public function addGame(Game $game)
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setLeague($this);
        }

        return $this;
    }

    public function removeGame(Game $game)
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getLeague() === $this) {
                $game->setLeague(null);
            }
        }

        return $this;
    }
}
