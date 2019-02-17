<?php

namespace App\Application\Command\Owner;


class CreateOwnerCommand
{
    private $name;
    private $fb_delegated;

    public function __construct(string $name, string $fb_delegated)
    {
        $this->name = $name;
        $this->fb_delegated = $fb_delegated;
    }
    public function getName()
    {
        return $this->name;
    }

    public function getFbDelegated()
    {
        return $this->fb_delegated;
    }
}

