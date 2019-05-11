<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipantRepository")
 */
class Participant implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Lastname;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Firstname;
    /**
     * @ORM\Column(type="integer")
     */
    private $Age;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Sex;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Mail;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Experience", inversedBy="participants")
     */
    private $Experiences;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Message", inversedBy="receiver")
     */
    private $Message;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ParticipationRequest", mappedBy="IdParticipant", orphanRemoval=true)
     */
    private $participationRequests;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Password;
    /**
     * @ORM\Column(type="integer")
     */
    private $registerExperience;
    /**
     * @ORM\Column(type="integer")
     */
    private $participatedExperience;
    public function __construct()
    {
        $this->Experiences = new ArrayCollection();
        $this->Message = new ArrayCollection();
        $this->participationRequests = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getLastname(): ?string
    {
        return $this->Lastname;
    }
    public function setLastname(string $Lastname): self
    {
        $this->Lastname = $Lastname;
        return $this;
    }
    public function getFirstname(): ?string
    {
        return $this->Firstname;
    }
    public function setFirstname(string $Firstname): self
    {
        $this->Firstname = $Firstname;
        return $this;
    }
    public function getAge(): ?int
    {
        return $this->Age;
    }
    public function setAge(int $Age): self
    {
        $this->Age = $Age;
        return $this;
    }
    public function getSex(): ?string
    {
        return $this->Sex;
    }
    public function setSex(string $Sex): self
    {
        $this->Sex = $Sex;
        return $this;
    }
    public function getMail(): ?string
    {
        return $this->Mail;
    }
    public function setMail(string $Mail): self
    {
        $this->Mail = $Mail;
        return $this;
    }
    /**
     * @return Collection|Experience[]
     */
    public function getExperiences(): Collection
    {
        return $this->Experiences;
    }
    public function addExperience(Experience $experience): self
    {
        if (!$this->Experiences->contains($experience)) {
            $this->Experiences[] = $experience;
        }
        return $this;
    }
    public function removeExperience(Experience $experience): self
    {
        if ($this->Experiences->contains($experience)) {
            $this->Experiences->removeElement($experience);
        }
        return $this;
    }
    /**
     * @return Collection|Message[]
     */
    public function getMessage(): Collection
    {
        return $this->Message;
    }
    public function addMessage(Message $message): self
    {
        if (!$this->Message->contains($message)) {
            $this->Message[] = $message;
        }
        return $this;
    }
    public function removeMessage(Message $message): self
    {
        if ($this->Message->contains($message)) {
            $this->Message->removeElement($message);
        }
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
            $participationRequest->setIdParticipant($this);
        }
        return $this;
    }
    public function removeParticipationRequest(ParticipationRequest $participationRequest): self
    {
        if ($this->participationRequests->contains($participationRequest)) {
            $this->participationRequests->removeElement($participationRequest);
            // set the owning side to null (unless already changed)
            if ($participationRequest->getIdParticipant() === $this) {
                $participationRequest->setIdParticipant(null);
            }
        }
        return $this;
    }
    public function getPassword(): ?string
    {
        return $this->Password;
    }
    public function setPassword(string $Password): self
    {
        $this->Password = $Password;
        return $this;
    }
    public function eraseCredentials(){}
        public function getSalt(){}
    
        public function getUsername()
        {
            return $this->Lastname;
        }
    
        public function getRoles()
        {
            return ['ROLE_USER'];
        }
        public function getRegisterExperience(): ?int
        {
            return $this->registerExperience;
        }
        public function setRegisterExperience(int $registerExperience): self
        {
            $this->registerExperience = $registerExperience;
            return $this;
        }
        public function getParticipatedExperience(): ?int
        {
            return $this->participatedExperience;
        }
        public function setParticipatedExperience(int $participatedExperience): self
        {
            $this->participatedExperience = $participatedExperience;
            return $this;
        }
}