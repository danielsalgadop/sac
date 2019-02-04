<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Repository\ActionRepository")
 */
class Action
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $http_verb;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $route;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\Thing", inversedBy="actions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Domain\Entity\Friend", mappedBy="actions")
     */
    private $friends;

    public function __construct()
    {
        $this->friends = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHttpVerb(): ?string
    {
        return $this->http_verb;
    }

    public function setHttpVerb(string $http_verb): self
    {
        $this->http_verb = $http_verb;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getWt(): ?Thing
    {
        return $this->wt;
    }

    public function setWt(?Thing $wt): self
    {
        $this->wt = $wt;

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
            $friend->addAction($this);
        }

        return $this;
    }

    public function removeFriend(Friend $friend): self
    {
        if ($this->friends->contains($friend)) {
            $this->friends->removeElement($friend);
            $friend->removeAction($this);
        }

        return $this;
    }
}
