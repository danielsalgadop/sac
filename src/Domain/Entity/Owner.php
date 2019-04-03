<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

class Owner
{
    private $id;
    private $name;
    private $fbDelegated;
    private $things;
    private $friends;

    public function __construct(string $name, string $fbDelegated)
    {
        // DUDA, tiene sentido setear estos params (name, fbDelegated usando métodos set*)? (asi podría validarlos)
        $this->validateName($name);
        $this->name = $name;
        $this->fbDelegated = $fbDelegated;
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

    public function getFbDelegated(): ?string
    {
        return $this->fbDelegated;
    }

    public function setFbDelegated(string $fbDelegated): self
    {
        $this->fbDelegated = $fbDelegated;

        return $this;
    }


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

    public function getThingByIdOrException(int $thingId): Thing
    {
        foreach ($this->getThings() as $thing) {
            if ($thing->getId() === $thingId) {
                return $thing;
            }
        }
        throw new \Exception("Thing does not belong to user");
    }

    private function validateName(string $name)
    {
        // TODO: ahora esta entrando (via POST) name=' '. Esto no debería pasar
        if ($name == '' || preg_match('/[0-9]/', $name)) {
            Throw new \Exception("Invalid Name for Owner");
        }
    }
//    public function toArray()
//    {
//         TODO: duda Victor (este serilizer, ¿esta bien?)
//         toArray aún. Lo que hay dentro de Dominio son estructuras "puras". Pero toJson, toXML, toHtml van a Infrastructura
//        return [
//            'name' => $this->getName(),
//            'id' => $this->getId()
//        ];
//    }

    public function getArrayFiendsIds(): array
    {
        $friendIds = [];
        foreach ($this->getFriends() as $friend) {
            $friendIds[] = $friend->getId();
        }
        return $friendIds;
    }
}
