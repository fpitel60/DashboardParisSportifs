<?php

namespace App\Entity;

use App\Repository\HighlightRepository;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HighlightRepository::class)
 */
class Highlight
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $resultHighlight;

    /**
    * @ORM\ManyToOne(targetEntity=TypeHighlight::class, inversedBy="highlights")
    */
    private $typeHighlight;

    /**
    * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="highlights")
    */
    private $game;

    /**
    * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="highlights")
    */
    private $player;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResultHighlight(): ?bool
    {
        return $this->resultHighlight;
    }

    public function setResultHighlight(?bool $resultHighlight): self
    {
        $this->resultHighlight = $resultHighlight;

        return $this;
    }

    public function getTypeHighlight(): ?TypeHighlight
    {
        return $this->typeHighlight;
    }

    public function setTypeHighlight(TypeHighlight $typeHighlight): self
    {
        $this->typeHighlight = $typeHighlight;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        $this->player = $player;

        return $this;
    }
}
