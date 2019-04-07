<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="text")
     */
    private $Content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Researcher", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Sender;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Participant", mappedBy="Message")
     */
    private $receiver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Experience", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $InRelationWith;

    public function __construct()
    {
        $this->receiver = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getSender(): ?Researcher
    {
        return $this->Sender;
    }

    public function setSender(?Researcher $Sender): self
    {
        $this->Sender = $Sender;

        return $this;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getReceiver(): Collection
    {
        return $this->receiver;
    }

    public function addReceiver(Participant $receiver): self
    {
        if (!$this->receiver->contains($receiver)) {
            $this->receiver[] = $receiver;
            $receiver->addMessage($this);
        }

        return $this;
    }

    public function removeReceiver(Participant $receiver): self
    {
        if ($this->receiver->contains($receiver)) {
            $this->receiver->removeElement($receiver);
            $receiver->removeMessage($this);
        }

        return $this;
    }

    public function getInRelationWith(): ?Experience
    {
        return $this->InRelationWith;
    }

    public function setInRelationWith(?Experience $InRelationWith): self
    {
        $this->InRelationWith = $InRelationWith;

        return $this;
    }
}
