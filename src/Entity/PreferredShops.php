<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PreferredShopsRepository")
 */
class PreferredShops
{
    const OPINION = [ "neutral" => 0, "liked" => 1,"disliked" => 2 ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="preferredShops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Shops", inversedBy="preferredShops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shops;

    /**
     * @ORM\Column(type="integer")
     */
    private $opinion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getShops(): ?Shops
    {
        return $this->shops;
    }

    public function setShops(?Shops $shops): self
    {
        $this->shops = $shops;

        return $this;
    }

    public function getOpinion(): ?int
    {
        return $this->opinion;
    }

    public function setOpinion(int $opinion): self
    {
        $this->opinion = $opinion;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
