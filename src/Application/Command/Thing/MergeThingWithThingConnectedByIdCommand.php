<?php

namespace App\Application\Command\Thing;


class MergeThingWithThingConnectedByIdCommand
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

