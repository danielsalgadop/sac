<?php

namespace App\Application\Command\Thing;

use App\Domain\Entity\Thing;

class GetThingConnectedInfoCommand
{
    private $thing;

    public function __construct(Thing $thing)
    {
        $this->thing = $thing;
    }

    public function getThing(): Thing
    {
        return $this->thing;
    }
}