<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
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
     * @ORM\Column(type="string", length=255)
     */
    private $countryCode;

    /**
    * @ORM\OneToMany(targetEntity=League::class, cascade={"persist", "remove"}, mappedBy="country")
    */
    protected $leagues;

    public function __construct()
    {
        $this->leagues = new ArrayCollection();
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

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getLeagues()
    {
        return $this->sports;
    }

    public function addLeague(League $league)
    {
        if (!$this->leagues->contains($league)) {
            $this->leagues[] = $league;
            $league->setCountry($this);
        }

        return $this;
    }

    public function removeLeague(League $league)
    {
        if ($this->leagues->contains($league)) {
            $this->leagues->removeElement($league);
            // set the owning side to null (unless already changed)
            if ($league->getCountry() === $this) {
                $league->setCountry(null);
            }
        }

        return $this;
    }
}
