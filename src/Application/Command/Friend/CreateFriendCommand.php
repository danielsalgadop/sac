<?php

namespace App\Application\Command\Friend;

class CreateFriendCommand
{
    private $fb_delegated;

    public function __construct(string $fb_delegated)
    {
        $this->fb_delegated = $fb_delegated;
    }

    public function getFbDelegated()
    {
        return $this->fb_delegated;
    }
}

