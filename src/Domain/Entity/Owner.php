<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OwnerRepository")
 */
class Owner
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fbDelegated;

    /**
     * @ORM\ManyToMany(targetEntity="App\Domain\Entity\Thing", inversedBy="owners")
     */
    private $things;

    /**
     * @ORM\ManyToMany(targetEntity="App\Domain\Entity\Friend", inversedBy="owners")
     */
    private $friends;

    public function __construct()
    {
        $this->things = new ArrayCollection();
        $this->friends = new ArrayCollection();
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFbDelegated(): ?string
    {
        return $this->fbDelegated;
    }

    public function setFbDelegated(string $fbDelegated): self
    {
        $this->fbDelegated = $fbDelegated;

        return $this;
    }

    /**
     * @return Collection|Thing[]
     */
    public function getThings(): Collection
    {
        return $this->things;
    }

    public function addThing(Thing $thing): self
    {
        if (!$this->things->contains($thing)) {
            $this->things[] = $thing;
        }

        return $this;
    }

    public function removeThing(Thing $thing): self
    {
        if ($this->things->contains($thing)) {
            $this->things->removeElement($thing);
        }

        return $this;
    }

    /**
     * @return Collection|Friend[]
     */
    public function getFriends(): Collection
    {
        return $this->friends;
    }

    public function addFriend(Friend $friend): self
    {
        if (!$this->friends->contains($friend)) {
            $this->friends[] = $friend;
        }

        return $this;
    }

    public function removeFriend(Friend $friend): self
    {
        if ($this->friends->contains($friend)) {
            $this->friends->removeElement($friend);
        }

        return $this;
    }
}
