<?php

namespace App\Entity;

use App\Entity\Team;
use Doctrine\ORM\Mapping as ORM;

class GameSearch {

    /**
     * @var \DateTime|null
     */
    private $date;

    /**
     * @var string|null
     */
    private $score;

    /**
    * @var Team::class
    */
    private $homeTeam;

    /**
    * @var Team::class
    */
    private $foreignTeam;

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
}