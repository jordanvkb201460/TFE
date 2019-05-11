<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipationRequestRepository")
 */
class ParticipationRequest
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Validated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant", inversedBy="participationRequests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $IdParticipant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Experience", inversedBy="participationRequests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $IdExperience;

    /**
     * @ORM\Column(type="integer")
     */
    private $Status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValidated(): ?int
    {
        return $this->Validated;
    }

    public function setValidated(int $Validated): self
    {
        $this->Validated = $Validated;

        return $this;
    }

    public function getIdParticipant(): ?Participant
    {
        return $this->IdParticipant;
    }

    public function setIdParticipant(?Participant $IdParticipant): self
    {
        $this->IdParticipant = $IdParticipant;

        return $this;
    }

    public function getIdExperience(): ?Experience
    {
        return $this->IdExperience;
    }

    public function setIdExperience(?Experience $IdExperience): self
    {
        $this->IdExperience = $IdExperience;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->Status;
    }

    public function setStatus(int $Status): self
    {
        $this->Status = $Status;

        return $this;
    }
}
