<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class BookmakerSearch {

    /**
     * @var string|null
     */
    private $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}