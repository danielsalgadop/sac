<?php

namespace App\Application\CommandHandler\Thing;

use App\Application\Command\Thing\GetActionsByThingIdCommand;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Domain\Entity\Thing;

class GetActionsByThingIdHandler
{

    private $searchThingByIdHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler)
    {
        $this->searchThingByIdHandler = $searchThingByIdHandler;
    }

    public function handle(GetActionsByThingIdCommand $getActionByThingIdCommand): ?object
    {
        /** @var $thing Thing */
        $thing = $this->searchThingByIdHandler->handle(new SearchThingByIdCommand($getActionByThingIdCommand->getThingId()));

        if (count($thing->getActions()) > 0) {
            return $thing->getActions();
        }
        return null;
    }
}