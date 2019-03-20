<?php

namespace App\Application\Command\Owner;

use App\Domain\Entity\Owner;

class GetListThingsByOwnerCommand
{
    private $owner;

    public function __construct(Owner $owner)
    {
        $this->owner = $owner;
    }

    public function getOwner()
    {
        return $this->owner;
    }
}

