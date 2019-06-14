<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


class Action
{
    private $id;
    private $route;
    private $wt;
    private $friends;

    // TODO: parameter of by setter, or by ->. Now they are mixed
    public function __construct(Thing $thing, string $route)
    {
        $this->wt = $thing;
        $this->setRoute($route);
        $this->friends = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
