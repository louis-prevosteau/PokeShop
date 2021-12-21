<?php

namespace App\Entity;

use App\Repository\DonationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DonationRepository::class)
 */
class Donation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $sum;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfDonation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="donations")
     */
    private $userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSum(): ?float
    {
        return $this->sum;
    }

    public function setSum(float $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    public function getDateOfDonation(): ?\DateTimeInterface
    {
        return $this->dateOfDonation;
    }

    public function setDateOfDonation(\DateTimeInterface $dateOfDonation): self
    {
        $this->dateOfDonation = $dateOfDonation;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
