<?php

namespace App\Application\Command\Friend;


class SearchFriendByFbDelegatedCommand
{
    private $friendFbDelegated;

    public function __construct(string $friendFbDelegated)
    {
        $this->friendFbDelegated = $friendFbDelegated;
    }

    public function getFbDelegated()
    {
        return $this->friendFbDelegated;
    }
}

