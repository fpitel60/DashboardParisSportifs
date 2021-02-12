<?php

namespace App\Entity;

use App\Entity\Sport;

class TypeHighlightSearch {

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var Sport::class
     */
    private $sport;


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
}