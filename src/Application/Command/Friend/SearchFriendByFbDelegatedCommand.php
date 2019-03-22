<?php

namespace App\Application\Command\Friend;


class SearchFriendByFbDelegatedCommand
{
    private $fbDelegated;

    public function __construct(string $fbDelegated)
    {
        $this->fbDelegated = $fbDelegated;
    }

    public function getFbDelegated()
    {
        return $this->fbDelegated;
    }
}

