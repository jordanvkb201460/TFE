<?php

namespace App\Entity;

use App\Service\RandomString;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResearcherRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields={"Mail"}, message="Cette adresse mail est déjà utilisée" )
 */
class Researcher implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer un nom valide")
     */
    private $Lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer un prenom valide")
     * @Assert\Length(min="2", minMessage="Votre mot de passe doit faire au minimum 2 caracteres")
     * @Assert\Length(max="2", maxMessage="Faut pas deconner")
     */
    private $Firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $Mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Department;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Experience", mappedBy="researcher", orphanRemoval=true)
     */
    private $Experiences;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="Sender", orphanRemoval=true)
     */
    private $messages;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire au minimum 8 caracteres")
     */
    private $Password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Erreur mots de passe différents")
     */
    private $ConfirmPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;


    public function __construct()
    {
        $this->Experiences = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function prepersist()
    {
        if(empty($this->isActive))
        {
            $this->isActive = false;
        }
        if(empty($this->token))
        {
            $this->token = RandomString::Generate($this->Firstname,$this->Lastname);
        }
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

    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(string $Mail): self
    {
        $this->Mail = $Mail;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->Department;
    }

    public function setDepartment(string $Department): self
    {
        $this->Department = $Department;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

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
            $experience->setResearcher($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): self
    {
        if ($this->Experiences->contains($experience)) {
            $this->Experiences->removeElement($experience);
            // set the owning side to null (unless already changed)
            if ($experience->getResearcher() === $this) {
                $experience->setResearcher(null);
            }
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
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
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

    public function getConfirmPassword(): ?string
    {
        return $this->ConfirmPassword;
    }

    public function setConfirmPassword(string $Password): self
    {
        $this->ConfirmPassword = $Password;

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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
