<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


class Action
{
    private $id;
    private $http_verb;
    private $route;
    private $description;
    private $wt;
    private $friends;

    // TODO: add all parameters by constructor
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
