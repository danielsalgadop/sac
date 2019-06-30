<?php

namespace App\Application\Command\Owner;


class SearchOwnerByFbDelegatedCommand
{
    private $ownerFbDelegated;

    public function __construct(int $ownerFbDelegated)
    {
        $this->ownerFbDelegated = $ownerFbDelegated;
    }

    public function getFbDelegated():int
    {
        return $this->ownerFbDelegated;
    }
}

