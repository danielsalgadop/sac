<?php

namespace App\Application\Command\Owner;


class CreateOwnerCommand
{
    private $name;
    private $fbDelegated;

    public function __construct(string $name, string $fbDelegated)
    {
        $this->name = $name;
        $this->fbDelgated = $fbDelegated;
    }
    public function getName()
    {
        return $this->name;
    }

    public function getFbDelegated()
    {
        return $this->fbDelgated;
    }
}

