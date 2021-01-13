<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardRepository::class)
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
}
