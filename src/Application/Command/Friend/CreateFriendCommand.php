<?php

namespace App\Application\Command\Friend;

class CreateFriendCommand
{
    private $fb_delegated;
    private $name;

    public function __construct(int $fb_delegated, string $name)
    {
        $this->fb_delegated = $fb_delegated;
        $this->name = $name;
    }

    public function getFbDelegated()
    {
        return $this->fb_delegated;
    }

    public function getName(): string
    {
        return $this->name;
    }

}

