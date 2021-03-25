<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Boolean;

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
    * @ORM\OneToMany(targetEntity=Bet::class, cascade={"persist", "remove"}, mappedBy="user")
    */
    protected $bets;

    /**
    * @ORM\OneToMany(targetEntity=Bankroll::class, cascade={"persist", "remove"}, mappedBy="user")
    */
    protected $bankrolls;

    /**
    * @ORM\OneToOne(targetEntity=Bankroll::class)
    */
    protected $defaultBankroll;

    public function __construct()
    {
        $this->bets = new ArrayCollection();
        $this->bankrolls = new ArrayCollection();
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

    public function getBets()
    {
        return $this->bets;
    }
     
    public function addBet(Bet $bet)
    {
        $this->bets->add($bet);
        $bet->setUser($this);
    }

    public function getBankrolls()
    {
        return $this->bankrolls;
    }
     
    public function addBankroll(Bankroll $bankroll)
    {
        $this->bankrolls->add($bankroll);
        $bankroll->setUser($this);
    }

    public function getDefaultBankroll()
    {
        return $this->defaultBankroll;
    }

    public function setDefaultBankroll(Bankroll $defaultBankroll): self
    {
        $this->defaultBankroll = $defaultBankroll;

        return $this;
    }
}
