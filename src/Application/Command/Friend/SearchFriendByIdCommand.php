<?php

namespace App\Application\Command\Friend;


class SearchFriendByIdCommand
{
    private $friendId;

    public function __construct(int $friendId)
    {
        $this->friendId = $friendId;
    }

    public function getId()
    {
        return $this->friendId;
    }
}

