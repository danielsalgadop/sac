<?php

namespace App\Application\Command\Owner;


class CreateOwnerCommand
{
    private $name;
    private $fbDelgated;

    public function __construct(string $name, string $fbDelgated)
    {
        $this->name = $name;
        $this->fbDelgated = $fbDelgated;
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

