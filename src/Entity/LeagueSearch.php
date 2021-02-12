<?php

namespace App\Entity;

use App\Entity\Sport;
use App\Entity\Country;

class LeagueSearch {

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var Sport::class
     */
    private $sport;

    /**
     * @var Country::class
     */
    private $country;

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

    public function setSport(Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry(Country $country): self
    {
        $this->country = $country;

        return $this;
    }
}