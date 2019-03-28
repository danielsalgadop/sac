<?php

namespace App\Application\Command\Owner;


class SearchOwnerByFbDelegatedCommand
{
    private $ownerFbDelegated;

    public function __construct(string $ownerFbDelegated)
    {
        $this->ownerFbDelegated = $ownerFbDelegated;
    }

    public function getFbDelegated():string
    {
        return $this->ownerFbDelegated;
    }
}

