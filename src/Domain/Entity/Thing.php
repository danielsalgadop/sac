<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

class Thing
{

    private $id;
    private $root;
    private $user;
    private $password;
    private $actions;
    private $owners;
    private $thingConnected;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
        $this->owners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoot(): ?string
    {
        return $this->root;
    }

    public function setRoot(string $root): self
    {
        $this->root = $root;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

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

    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setWt($this);
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
            // set the owning side to null (unless already changed)
            if ($action->getWtId() === $this) {
                $action->setWt(null);
            }
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
            $owner->addThing($this);
        }

        return $this;
    }

    public function removeOwner(Owner $owner): self
    {
        if ($this->owners->contains($owner)) {
            $this->owners->removeElement($owner);
            $owner->removeThing($this);
        }

        return $this;
    }

    public function setThingConnected($thingConnected)
    {
        $this->thingConnected = $thingConnected;
    }
    public function getThingConnected()
    {
        return $this->thingConnected;
    }
}
