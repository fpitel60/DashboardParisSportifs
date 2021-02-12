<?php

namespace App\Entity;

use App\Entity\League;

class TeamSearch {

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var League::class
     */
    private $league;


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

    public function setLeague(League $league): self
    {
        $this->league = $league;

        return $this;
    }
}