<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\WebContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebContactRepository::class)]
#[ApiResource]
class WebContact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $isAn = null;

    #[ORM\Column(length: 255)]
    private ?string $lstName = null;

    #[ORM\Column(length: 255)]
    private ?string $fstName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $situation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $needs = null;

    #[ORM\Column]
    private ?int $knowSz = null;

    // #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    // private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsAn(): ?int
    {
        return $this->isAn;
    }

    public function setIsAn(int $isAn): static
    {
        $this->isAn = $isAn;

        return $this;
    }

    public function getLstName(): ?string
    {
        return $this->lstName;
    }

    public function setLstName(string $lstName): static
    {
        $this->lstName = $lstName;

        return $this;
    }

    public function getFstName(): ?string
    {
        return $this->fstName;
    }

    public function setFstName(string $fstName): static
    {
        $this->fstName = $fstName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getSituation(): ?int
    {
        return $this->situation;
    }

    public function setSituation(int $situation): static
    {
        $this->situation = $situation;

        return $this;
    }

    public function getNeeds(): ?string
    {
        return $this->needs;
    }

    public function setNeeds(string $needs): static
    {
        $this->needs = $needs;

        return $this;
    }

    public function getKnowSz(): ?int
    {
        return $this->knowSz;
    }

    public function setKnowSz(int $knowSz): static
    {
        $this->knowSz = $knowSz;

        return $this;
    }

    // public function getCreatedAt(): ?\DateTimeInterface
    // {
    //     return $this->createdAt;
    // }

    // public function setCreatedAt(\DateTimeInterface $createdAt): static
    // {
    //     $this->createdAt = $createdAt;

    //     return $this;
    // }
}
