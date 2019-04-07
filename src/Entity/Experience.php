<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExperienceRepository")
 */
class Experience
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Compensation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Place;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Feedback;

    /**
     * @ORM\Column(type="boolean")
     */
    private $FreeReq;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $AgeReq;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SexReq;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $SpecifiqReq;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Researcher", inversedBy="Experiences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $researcher;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Participant", mappedBy="Experiences")
     */
    private $participants;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="InRelationWith", orphanRemoval=true)
     */
    private $messages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ParticipationRequest", mappedBy="IdExperience", orphanRemoval=true)
     */
    private $participationRequests;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datefin;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->participationRequests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $Id): self
    {
        $this->id = $Id;

        return $this;
    }

    public function getCompensation(): ?float
    {
        return $this->Compensation;
    }

    public function setCompensation(?float $Compensation): self
    {
        $this->Compensation = $Compensation;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->Place;
    }

    public function setPlace(string $Place): self
    {
        $this->Place = $Place;

        return $this;
    }

    public function getFeedback(): ?string
    {
        return $this->Feedback;
    }

    public function setFeedback(?string $Feedback): self
    {
        $this->Feedback = $Feedback;

        return $this;
    }

    public function getFreeReq(): ?bool
    {
        return $this->FreeReq;
    }

    public function setFreeReq(bool $FreeReq): self
    {
        $this->FreeReq = $FreeReq;

        return $this;
    }

    public function getAgeReq(): ?int
    {
        return $this->AgeReq;
    }

    public function setAgeReq(?int $AgeReq): self
    {
        $this->AgeReq = $AgeReq;

        return $this;
    }

    public function getSexReq(): ?string
    {
        return $this->SexReq;
    }

    public function setSexReq(?string $SexReq): self
    {
        $this->SexReq = $SexReq;

        return $this;
    }

    public function getSpecifiqReq(): ?string
    {
        return $this->SpecifiqReq;
    }

    public function setSpecifiqReq(?string $SpecifiqReq): self
    {
        $this->SpecifiqReq = $SpecifiqReq;

        return $this;
    }

    public function getResearcher(): ?Researcher
    {
        return $this->researcher;
    }

    public function setResearcher(?Researcher $researcher): self
    {
        $this->researcher = $researcher;

        return $this;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->addExperience($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
            $participant->removeExperience($this);
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setInRelationWith($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getInRelationWith() === $this) {
                $message->setInRelationWith(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection|ParticipationRequest[]
     */
    public function getParticipationRequests(): Collection
    {
        return $this->participationRequests;
    }

    public function addParticipationRequest(ParticipationRequest $participationRequest): self
    {
        if (!$this->participationRequests->contains($participationRequest)) {
            $this->participationRequests[] = $participationRequest;
            $participationRequest->setIdExperience($this);
        }

        return $this;
    }

    public function removeParticipationRequest(ParticipationRequest $participationRequest): self
    {
        if ($this->participationRequests->contains($participationRequest)) {
            $this->participationRequests->removeElement($participationRequest);
            // set the owning side to null (unless already changed)
            if ($participationRequest->getIdExperience() === $this) {
                $participationRequest->setIdExperience(null);
            }
        }

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }  
}
