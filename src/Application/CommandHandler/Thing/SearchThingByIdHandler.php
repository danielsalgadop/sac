<?php

namespace App\Application\CommandHandler\Thing;

use App\Application\Command\Thing\ThingConnected\GetThingConnectedCompleteByIdCommand;
use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingRepository;

class SearchThingByIdHandler
{
    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function handle(GetThingConnectedCompleteByIdCommand $getThingConnectedByIdCommand):Thing
    {
        return $this->thingRepository->searchThingByIdOrException($getThingConnectedByIdCommand->getThingId());
    }
}
