<?php

namespace App\Application\Command\Thing;

class GetActionsByThingIdCommand
{
    private $thingId;

    public function __construct(int $thingId)
    {
        $this->thingId = $thingId;
    }

    public function getThingId()
    {
        return $this->thingId;
    }
}

