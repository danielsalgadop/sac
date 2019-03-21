<?php

namespace App\Application\CommandHandler\Thing;


use App\Domain\Entity\Owner;
use App\Application\Command\Thing\GetActionsByThingIdCommand;
use App\Domain\Repository\ThingRepository;


class GetActionsByThingIdHandler
{

    private $thingRepository;

    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }


    // TODO: return type
    public function handle(GetActionsByThingIdCommand $getActionByThingIdCommand)
    {

        $thingId = $getActionByThingIdCommand->getThingId();
        $thing = $this->thingRepository
            ->find($thingId);
        return $thing->getActions();
    }
}