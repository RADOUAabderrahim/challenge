<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShopsRepository")
 */
class Shops
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(1)
     */
    private $distance;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PreferredShops", mappedBy="shops", orphanRemoval=true)
     */
    private $preferredShops;

    public function __construct()
    {
        $this->preferredShops = new ArrayCollection();
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

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return Collection|PreferredShops[]
     */
    public function getPreferredShops(): Collection
    {
        return $this->preferredShops;
    }

    public function addPreferredShop(PreferredShops $preferredShop): self
    {
        if (!$this->preferredShops->contains($preferredShop)) {
            $this->preferredShops[] = $preferredShop;
            $preferredShop->setShops($this);
        }

        return $this;
    }

    public function removePreferredShop(PreferredShops $preferredShop): self
    {
        if ($this->preferredShops->contains($preferredShop)) {
            $this->preferredShops->removeElement($preferredShop);
            // set the owning side to null (unless already changed)
            if ($preferredShop->getShops() === $this) {
                $preferredShop->setShops(null);
            }
        }

        return $this;
    }
}
