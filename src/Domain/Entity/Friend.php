<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

class Friend
{
    private $id;
    private $fbDelegated;
    private $actions;
    private $owners;

    public function __construct(string $fbDelegated)
    {
        $this->actions = new ArrayCollection();
        $this->owners = new ArrayCollection();
        $this->fbDelegated = $fbDelegated;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFbDelegated(): ?string
    {
        return $this->fbDelegated;
    }

//    public function setFbDelegated(string $fbDelegated): self
//    {
//        $this->fbDelegated = $fbDelegated;
//
//        return $this;
//    }


    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
        }

        return $this;
    }

    public function getOwners(): Collection
    {
        return $this->owners;
    }

    public function addOwner(Owner $owner): self
    {
        if (!$this->owners->contains($owner)) {
            $this->owners[] = $owner;
            $owner->addFriend($this);
        }

        return $this;
    }

    public function removeOwner(Owner $owner): self
    {
        if ($this->owners->contains($owner)) {
            $this->owners->removeElement($owner);
            $owner->removeFriend($this);
        }

        return $this;
    }
}
