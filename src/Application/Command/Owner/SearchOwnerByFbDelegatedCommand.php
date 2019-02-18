<?php

namespace App\Application\Command\Owner;


class SearchOwnerByFbDelegatedCommand
{
    private $fb_delegated;

    public function __construct(string $fb_delegated)
    {
        $this->fb_delegated = $fb_delegated;
    }

    public function getFbDelegated()
    {
        return "fb_delegated_1"; //TODO: quitar este hardcoded
        return $this->fb_delegated;
    }
}

