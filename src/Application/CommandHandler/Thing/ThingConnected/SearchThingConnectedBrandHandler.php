<?php

namespace App\Application\CommandHandler\Thing\ThingConnected;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingConnectedRepository;


class SearchThingConnectedBrandHandler
{

    private $thingConnectedRepository;

    public function __construct(ThingConnectedRepository $thingConnectedRepository)
    {
        $this->thingConnectedRepository = $thingConnectedRepository;
    }

    public function handle(GetThingConnectedInfoCommand $getThingConnectedInfoCommand)
    {
        /** @var Thing $thing */
        $thing = $getThingConnectedInfoCommand->getThing();
        return $this->thingConnectedRepository->searchThingBrandByIdOrException(
            $thing->getRoot(),
            $thing->getUser(),
            $thing->getPassword()
        );
    }

}