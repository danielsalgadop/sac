<?php

namespace App\Application\Command\Friend;


class SearchFriendByFbDelegatedCommand
{
    private $frienFbDelegated;

    public function __construct(string $frienFbDelegated)
    {
        $this->frienFbDelegated = $frienFbDelegated;
    }

    public function getFbDelegated()
    {
        return $this->frienFbDelegated;
    }
}

