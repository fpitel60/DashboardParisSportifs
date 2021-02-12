<?php

namespace App\Entity;

use App\Entity\Game;
use App\Entity\Player;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
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
    * @ORM\ManyToOne(targetEntity=League::class, inversedBy="teams")
    */
    private $league;

    /**
    * @ORM\OneToMany(targetEntity=Player::class, cascade={"persist", "remove"}, mappedBy="team")
    */
    protected $players;

    /**
    * @ORM\OneToMany(targetEntity=Game::class, cascade={"persist", "remove"}, mappedBy="team")
    */
    protected $games;

    public function __construct()
    {
        $this->players = new ArrayCollection();
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

    public function getLeague()
    {
        return $this->league;
    }

    public function setLeague($league)
    {
        $this->league = $league;

        return $this;
    }

    public function getPlayers()
    {
        return $this->players;
    }

    public function addPlayer(Player $player)
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setTeam($this);
        }

        return $this;
    }

    public function removePlayer(Player $player)
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getTeam() === $this) {
                $player->setTeam(null);
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
            if($game['homeTeam']) {
                $game->setHomeTeam($this);
            }
            elseif ($game['foreignTeam']) {
                $game->setForeignTeam($this);
            }
        }

        return $this;
    }

    public function removeGame(Game $game)
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getHomeTeam() === $this) {
                $game->setHomeTeam(null);
            }
            elseif ($game->getForeignTeam() === $this) {
                $game->setForeignTeam(null);
            }
        }

        return $this;
    }
}
