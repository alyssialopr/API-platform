<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Enum\AppointmentStatus;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]

#[ApiResource(
    forceEager: false,
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    operations:[
        new GetCollection(
            security: "is_granted('ROLE_VETERINARIAN')",
            securityMessage: "Only veterinarians can access this resource"
        ),
        new Get(
            security: "is_granted('ROLE_ASSISTANT') or is_granted('ROLE_VETERINARIAN')",
            securityMessage: "Only assistants can access this resource"
        ),
        new Post(),
        new Patch(
            security: "is_granted('ROLE_ASSISTANT')",
            securityMessage: "Only assistants can access this resource"
        ),
        new Delete(
            security: "is_granted('ROLE_VETERINARIAN')",
            securityMessage: "Only veterinarians can access this resource"
        ),
    ]
)]

class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('read')]
    private ?\DateTimeInterface $createdDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read', 'write'])]
    private ?\DateTimeInterface $apDate = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read', 'write'])]
    private ?string $motive = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]

    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?User $assistant = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?User $vet = null;

    #[ORM\Column(type: 'string', length: 255, enumType: AppointmentStatus::class)]
    #[Groups(['read', 'write'])]
    private ?AppointmentStatus $status = null;

    /**
     * @var Collection<int, Treatment>
     */
    #[ORM\ManyToMany(targetEntity: Treatment::class)]
    #[Groups(['read', 'write'])]
    private Collection $treatments;

    #[ORM\Column(nullable: true)]
    private ?bool $paymentStatus = null;

    #[ORM\Column(nullable: true)]
    private ?float $payment = null;

    public function __construct()
    {
        $this->treatments = new ArrayCollection();

        $this->createdDate = new \DateTime(
            datetime: 'now',
            timezone: new \DateTimeZone('Europe/Paris')
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): static
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getApDate(): ?\DateTimeInterface
    {
        return $this->apDate;
    }

    public function setApDate(\DateTimeInterface $apDate): static
    {
        $this->apDate = $apDate;

        return $this;
    }

    public function getMotive(): ?string
    {
        return $this->motive;
    }

    public function setMotive(string $motive): static
    {
        $this->motive = $motive;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getAssistant(): ?User
    {
        return $this->assistant;
    }

    public function setAssistant(?User $assistant): static
    {
        $this->assistant = $assistant;

        return $this;
    }

    public function getVet(): ?User
    {
        return $this->vet;
    }

    public function setVet(?User $vet): static
    {
        $this->vet = $vet;

        return $this;
    }

    public function getStatus(): ?AppointmentStatus
    {
        return $this->status;
    }

    public function setStatus(AppointmentStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Treatment>
     */
    public function getTreatments(): Collection
    {
        return $this->treatments;
    }

    public function addTreatment(Treatment $treatment): static
    {
        if (!$this->treatments->contains($treatment)) {
            $this->treatments->add($treatment);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): static
    {
        $this->treatments->removeElement($treatment);

        return $this;
    }

    public function isPaymentStatus(): ?bool
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(?bool $paymentStatus): static
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    public function getPayment(): ?float
    {
        return $this->payment;
    }

    public function setPayment(?float $payment): static
    {
        $this->payment = $payment;

        return $this;
    }
}
