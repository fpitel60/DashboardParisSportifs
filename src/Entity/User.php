<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $benefsCumul;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $misesCumul;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $roi;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $startBankroll;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $currentBankroll;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $roc;

    /**
    * @ORM\OneToMany(targetEntity=Bet::class, cascade={"persist", "remove"}, mappedBy="user")
    */
    protected $bets;

    /**
    * @ORM\OneToMany(targetEntity=BetTest::class, cascade={"persist", "remove"}, mappedBy="user")
    */
    protected $betstest;

    public function __construct()
    {
        $this->bets = new ArrayCollection();
        $this->betstest = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBenefsCumul(): ?float
    {
        return $this->benefsCumul;
    }

    public function setBenefsCumul(float $benefsCumul): self
    {
        $this->benefsCumul = $benefsCumul;

        return $this;
    }

    public function getMisesCumul(): ?float
    {
        return $this->misesCumul;
    }

    public function setMisesCumul(float $misesCumul): self
    {
        $this->misesCumul = $misesCumul;

        return $this;
    }

    public function getRoi(): ?float
    {
        return $this->roi;
    }

    public function setRoi(float $roi): self
    {
        $this->roi = $roi;

        return $this;
    }

    public function getCurrentBankroll(): ?float
    {
        return $this->currentBankroll;
    }

    public function setCurrentBankroll(float $currentBankroll): self
    {
        $this->currentBankroll = $currentBankroll;

        return $this;
    }

    public function getStartBankroll(): ?float
    {
        return $this->startBankroll;
    }

    public function setStartBankroll(float $startBankroll): self
    {
        $this->startBankroll = $startBankroll;

        return $this;
    }

    public function getRoc(): ?float
    {
        return $this->roc;
    }

    public function setRoc(float $roc): self
    {
        $this->roc = $roc;

        return $this;
    }

    public function getBets()
    {
        return $this->bets;
    }
     
    public function addBet(Bet $bet)
    {
        $this->bets->add($bet);
        $bet->setUser($this);
    }

    public function getBetsTest()
    {
        return $this->betstest;
    }
     
    public function addBetTest(Bet $bettest)
    {
        $this->betstest->add($bettest);
        $bettest->setUser($this);
    }
}
