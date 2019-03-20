<?php

namespace App\Application\Command\Owner;


class SearchOwnerByFbDelegatedCommand
{
    private $fbDelegated;

    public function __construct(string $fbDelegated)
    {
        $this->fbDelegated = $fbDelegated;
    }

    public function getFbDelegated():string
    {
        return $this->fbDelegated;
    }
}

