<?php


namespace App\Application\Command\Owner;

class AddFriendCommand
{
    private $fb_delegated;

    // TODO: esto esta mal Owner\AddFriendCommand debe recibir Friend
    public function __construct(string $fb_delegated)
    {
        $this->fb_delegated = $fb_delegated;
    }

    public function getFbDelegated()
    {
        return $this->fb_delegated;
    }
}

