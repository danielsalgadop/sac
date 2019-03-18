<?php

namespace App\Application\Command\Owner;
use App\Domain\Entity\Owner;

class GetFbSharingStatusByOwnerCommand
{
    private $owner;

    public function __construct(Owner $owner)
    {
        $this->owner = $owner;
    }

    public function getFbDelegated()
    {
        return $this->owner;
    }
}

