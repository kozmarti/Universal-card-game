<?php

namespace App\Entity;

use App\Repository\CardsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardsRepository::class)
 */
class Cards
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
    private $player;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInDeck;

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsDiscard;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="discards")
     */
    private $playerDiscard;

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

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): self
    {
        $this->player = $player;

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
        return $this->IsDiscard;
    }

    public function setIsDiscard(bool $IsDiscard): self
    {
        $this->IsDiscard = $IsDiscard;

        return $this;
    }

    public function getPlayerDiscard(): ?User
    {
        return $this->playerDiscard;
    }

    public function setPlayerDiscard(?User $playerDiscard): self
    {
        $this->playerDiscard = $playerDiscard;

        return $this;
    }
}
