<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContractRepository::class)
 */
class Contract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Pokemon::class, cascade={"persist", "remove"})
     */
    private $PokemonId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contracts")
     */
    private $UserId;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfContract;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPokemonId(): ?Pokemon
    {
        return $this->PokemonId;
    }

    public function setPokemonId(?Pokemon $PokemonId): self
    {
        $this->PokemonId = $PokemonId;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->UserId;
    }

    public function setUserId(?User $UserId): self
    {
        $this->UserId = $UserId;

        return $this;
    }

    public function getDateOfContract(): ?\DateTimeInterface
    {
        return $this->dateOfContract;
    }

    public function setDateOfContract(\DateTimeInterface $dateOfContract): self
    {
        $this->dateOfContract = $dateOfContract;

        return $this;
    }
}
