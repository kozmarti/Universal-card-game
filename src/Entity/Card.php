<?php

namespace App\Entity;

use App\Repository\CardRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Card
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cards")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInDeck;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDiscard;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="discards")
     */
    private $userDiscard;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVisible;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPlayed;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIsInDeck(): ?bool
    {
        return $this->isInDeck;
    }

    public function setIsInDeck(bool $isInDeck): self
    {
        $this->isInDeck = $isInDeck;

        return $this;
    }

    public function getIsDiscard(): ?bool
    {
        return $this->isDiscard;
    }

    public function setIsDiscard(bool $isDiscard): self
    {
        $this->isDiscard = $isDiscard;

        return $this;
    }

    public function getUserDiscard(): ?User
    {
        return $this->userDiscard;
    }

    public function setUserDiscard(?User $userDiscard): self
    {
        $this->userDiscard = $userDiscard;

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function getIsPlayed(): ?bool
    {
        return $this->isPlayed;
    }

    public function setIsPlayed(?bool $isPlayed): self
    {
        $this->isPlayed = $isPlayed;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }


    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }


}
