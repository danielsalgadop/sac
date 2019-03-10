<?php

namespace App\Application\Command\Owner;

use App\Domain\Entity\Thing;
use App\Domain\Entity\Owner;

class AddThingCommand
{
    private $thing;
    private $owner;

    public function __construct(Thing $thing, Owner $owner)
    {
        $this->thing = $thing;
        $this->owner = $owner;
    }

    public function getThing():Thing
    {
        return $this->thing;
    }

    public function getOwner():Owner
    {
        return $this->owner;
    }
}

