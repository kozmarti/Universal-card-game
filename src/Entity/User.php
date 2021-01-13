<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Cards::class, mappedBy="player")
     */
    private $cards;

    /**
     * @ORM\OneToMany(targetEntity=Cards::class, mappedBy="playerDiscard")
     */
    private $discards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->discards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Cards[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Cards $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setPlayer($this);
        }

        return $this;
    }

    public function removeCard(Cards $card): self
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getPlayer() === $this) {
                $card->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cards[]
     */
    public function getDiscards(): Collection
    {
        return $this->discards;
    }

    public function addDiscard(Cards $discard): self
    {
        if (!$this->discards->contains($discard)) {
            $this->discards[] = $discard;
            $discard->setPlayerDiscard($this);
        }

        return $this;
    }

    public function removeDiscard(Cards $discard): self
    {
        if ($this->discards->removeElement($discard)) {
            // set the owning side to null (unless already changed)
            if ($discard->getPlayerDiscard() === $this) {
                $discard->setPlayerDiscard(null);
            }
        }

        return $this;
    }
}
