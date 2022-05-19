<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package App\Entity
 */
class User implements UserInterface
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string|null
     */
    private ?string $firstname;

    /**
     * @var string|null
     */
    private ?string $lastname;

    /**
     * @var string|null
     */
    private ?string $email;

    /**
     * @var string|null
     */
    private ?string $phone;

    /**
     * @var string|null
     */
    private ?string $username;

    /**
     * @var Address|null
     */
    private ?Address $address;

    /**
     * @var Collection
     */
    private Collection $commands;

    /**
     * @var Collection
     */
    private Collection $gifs;

    /**
     * @var array
     */
    private array $roles = [];

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->firstname." ".$this->lastname;
    }

    public function __construct()
    {
        $this->commands = new ArrayCollection();
        $this->gifs = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address|null $address
     */
    public function setAddress(?Address $address): void
    {
        $this->address = $address;
    }


    /**
     * @return Collection
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }

    /**
     * @param Collection $commands
     */
    public function setCommands(Collection $commands): void
    {
        $this->commands = $commands;
    }

    /**
     * @param Command $command
     *
     * @return $this
     */
    public function addCommand(Command $command): self
    {
        if ($command instanceof Command) {
            $this->commands->add($command);
        }
        return $this;
    }

    /**
     * @param Command $command
     *
     * @return User
     */
    public function removeCommand(Command $command): User
    {
        if ($command instanceof Command) {
            $this->commands->remove($command);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getGifs(): Collection
    {
        return $this->gifs;
    }

    /**
     * @param Collection $gifs
     */
    public function setGifs(Collection $gifs): void
    {
        $this->gifs = $gifs;
    }

    /**
     * @param Gif $gif
     *
     * @return $this
     */
    public function addGif(Gif $gif): self
    {
        if ($gif instanceof Gif) {
            $this->gifs->add($gif);
        }
        return $this;
    }

    /**
     * @param Gif $gif
     *
     * @return User
     */
    public function removeGif(Gif $gif): User
    {
        if ($gif instanceof Gif) {
            $this->gifs->remove($gif);
        }

        return $this;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->id;
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
    public function eraseCredentials(): bool
    {
      return false;
    }
}
