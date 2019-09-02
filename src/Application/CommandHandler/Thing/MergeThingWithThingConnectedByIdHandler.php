<?php

namespace App\Application\CommandHandler\Thing;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\Command\Thing\MergeThingWithThingConnectedByIdCommand;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Thing\ThingConnected\GetThingConnectedCompleteHandler;
use App\Domain\Entity\Thing;

class MergeThingWithThingConnectedByIdHandler
{
    private $searchThingByIdHandler;
    private $getThingConnectedCompleteHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler, GetThingConnectedCompleteHandler $getThingConnectedCompleteHandler)
    {
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->getThingConnectedCompleteHandler = $getThingConnectedCompleteHandler;
    }

    public function handle(MergeThingWithThingConnectedByIdCommand $mergeThingWithThingConnectedByIdCommand): Thing
    {
        /* @var Thing $thing */
        $thing = $this->searchThingByIdHandler->handle(
            new SearchThingByIdCommand($mergeThingWithThingConnectedByIdCommand->getThingId())
        );

        $thingConnected = $this->getThingConnectedCompleteHandler->handle(
            new GetThingConnectedInfoCommand(
                $thing->getId(),
                $thing->getUser(),
                $thing->getPassword()
            )
        );
        $thing->setThingConnected($thingConnected);
        return $thing;
    }
}
