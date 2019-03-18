<?php

namespace App\Application\Command\Owner;


class SearchOwnerByFbDelegatedCommand
{
    private $fb_delegated;

    public function __construct(string $fb_delegated)
    {
        $this->fb_delegated = $fb_delegated;
    }

    public function getFbDelegated():string
    {
        return $this->fb_delegated;
    }
}

