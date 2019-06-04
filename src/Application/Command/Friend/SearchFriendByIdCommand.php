<?php

namespace App\Application\Command\Friend;


class SearchFriendByIdCommand
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}

