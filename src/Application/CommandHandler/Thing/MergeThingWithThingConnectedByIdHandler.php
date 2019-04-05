<?php

namespace App\Application\CommandHandler\Thing;

use App\Application\Command\Thing\MergeThingWithThingConnectedByIdCommand;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\CommandHandler\Thing\ThingConnected\SearchThingConnectedCompleteHandler;
use App\Domain\Entity\Thing;

class MergeThingWithThingConnectedByIdHandler
{
    private $searchThingByIdHandler;
    private $searchThingConnectedCompleteHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler, SearchThingConnectedCompleteHandler $searchThingConnectedCompleteHandler)
    {
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->searchThingConnectedCompleteHandler = $searchThingConnectedCompleteHandler;
    }

    public function handle(MergeThingWithThingConnectedByIdCommand $mergeThingWithThingConnectedByIdCommand): Thing
    {
//        $mergeThingWithThingConnectedByIdCommand->getThingId()
        $thing = $this->searchThingByIdHandler->handle(
            new SearchThingByIdCommand($mergeThingWithThingConnectedByIdCommand->getThingId())
        );

        $thingConnected = $this->searchThingConnectedCompleteHandler->handle(
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
