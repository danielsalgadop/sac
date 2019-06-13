<?php

namespace App\Application\Command\Action;

use App\Domain\Entity\Thing;
use App\Domain\Entity\Friend;

class CreateActionCommand
{
    private $thing;
    private $route;

    public function __construct(Thing $thing, string $route)
    {
        $this->thing = $thing;
        $this->route = $route;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getThing():Thing
    {
        return $this->thing;
    }
}

