<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 */
class User implements UserInterface,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PreferredShops", mappedBy="user", orphanRemoval=true)
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function serialize()
    {
        return serialize([$this->id,$this->email,$this->password]);
    }

    public function unserialize($serialized)
    {
        list($this->id,$this->email,$this->password) = unserialize($serialized,['allowed_classes'=>false]);
    }

    public function getRoles()
    {
        $roles = explode(';', $this->roles);
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);      //return explode(';', $this->roles) ;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


    public function getUsername():?string
    {
       return (string) $this->email;
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
            $preferredShop->setUser($this);
        }

        return $this;
    }

    public function removePreferredShop(PreferredShops $preferredShop): self
    {
        if ($this->preferredShops->contains($preferredShop)) {
            $this->preferredShops->removeElement($preferredShop);
            // set the owning side to null (unless already changed)
            if ($preferredShop->getUser() === $this) {
                $preferredShop->setUser(null);
            }
        }

        return $this;
    }


}
