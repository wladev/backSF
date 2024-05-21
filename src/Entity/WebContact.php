<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Controller\WebContactController;
use App\Repository\WebContactRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: WebContactRepository::class)]
#[ApiResource(
    operations: [
        new \ApiPlatform\Metadata\GetCollection(),
        new \ApiPlatform\Metadata\Post(
            uriTemplate: '/web_contacts',
            controller: WebContactController::class,
            deserialize: false,
            openapiContext: [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'isAn' => ['type' => 'integer'],
                                    'lstName' => ['type' => 'string'],
                                    'fstName' => ['type' => 'string'],
                                    'email' => ['type' => 'string'],
                                    'situation' => ['type' => 'integer'],
                                    'needs' => ['type' => 'string'],
                                    'knowSz' => ['type' => 'integer'],
                                    'cvFile' => ['type' => 'string', 'format' => 'binary'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ),
        new \ApiPlatform\Metadata\Get(),
        new \ApiPlatform\Metadata\Put(),
        new \ApiPlatform\Metadata\Delete(),
    ]
)]
#[Vich\Uploadable]
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

    #[Vich\UploadableField(mapping: 'cv_files', fileNameProperty: 'cvFileName')]
    private ?File $cvFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cvFileName = null;
    

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct() {
        $this->updatedAt = new DateTime();
    }

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

    public function setCvFile(?File $cvFile = null): void
    {
        $this->cvFile = $cvFile;

        if (null !== $cvFile) {
            $this->updatedAt = new \DateTime();
        }
    }

    public function getCvFile(): ?File
    {
        return $this->cvFile;
    }

    public function setCvFileName(?string $cvFileName): void
    {
        $this->cvFileName = $cvFileName;
    }

    public function getCvFileName(): ?string
    {
        return $this->cvFileName;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $createdAt): static
    {
        $this->updatedAt = $createdAt;

        return $this;
    }

}
