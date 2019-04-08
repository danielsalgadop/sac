<?php

namespace App\Application\Command\Thing\ThingConnected;


class GetThingConnectedCompleteByIdCommand
{
    private $thingId;

    public function __construct(int $thingId)
    {

        $this->thingId = $thingId;
    }

    public function getThingId(): int
    {
        return $this->thingId;
    }
}

