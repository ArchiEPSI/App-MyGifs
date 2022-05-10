<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $lastname;

    /**
     * @var string
     */
    private string $firstname;

    /**
     * @var string
     */
    private string $phone;

    /**
     * @var Address
     */
    private Address $address;

    /**
     * @var string
     */
    private string $email;


    private Collection $commands;

    /**
     * @var Collection
     */
    private Collection $transactions;

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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAdress(Address $address): void
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
     * @return Collection
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    /**
     * @param Collection $transactions
     */
    public function setTransactions(Collection $transactions): void
    {
        $this->transactions = $transactions;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
