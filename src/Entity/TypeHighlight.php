<?php

namespace App\Entity;

use App\Entity\Highlight;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeHighlightRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=TypeHighlightRepository::class)
 */
class TypeHighlight
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sign;

    /**
     * @ORM\Column(type="float")
     */
    private $nombre;

    /**
    * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="typehighlights")
    */
    private $sport;

    /**
    * @ORM\OneToMany(targetEntity=Highlight::class, cascade={"persist", "remove"}, mappedBy="typeHighlight")
    */
    protected $highlights;

    public function __construct()
    {
        $this->highlights = new ArrayCollection();
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

    public function getSign(): ?string
    {
        return $this->sign;
    }

    public function setSign(string $sign): self
    {
        $this->sign = $sign;

        return $this;
    }

    public function getNombre(): ?float
    {
        return $this->nombre;
    }

    public function setNombre(float $nombre): self
    {
        $this->nombre = $nombre;

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

    public function getTypeHighlights()
    {
        return $this->highlights;
    }

    public function addTypeHighlight(Highlight $highlight)
    {
        if (!$this->highlights->contains($highlight)) {
            $this->highlights[] = $highlight;
            $highlight->setTypeHighlight($this);
        }

        return $this;
    }

    public function removeTypeHighlight(Highlight $highlight)
    {
        if ($this->highlights->contains($highlight)) {
            $this->highlights->removeElement($highlight);
            // set the owning side to null (unless already changed)
            if ($highlight->getTypeHighlight() === $this) {
                $highlight->setTypeHighlight(null);
            }
        }

        return $this;
    }
}
