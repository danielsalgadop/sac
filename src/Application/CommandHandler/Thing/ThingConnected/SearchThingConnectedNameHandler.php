<?php

namespace App\Application\CommandHandler\Thing\ThingConnected;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Domain\Repository\ThingConnectedRepository;


class SearchThingConnectedNameHandler
{

    private $thingConnectedRepository;

    public function __construct(ThingConnectedRepository $thingConnectedRepository)
    {
        $this->thingConnectedRepository = $thingConnectedRepository;
    }

    public function handle(GetThingConnectedInfoCommand $getThingConnectedInfoCommand)
    {
        return $this->thingConnectedRepository->searchThingNameByIdOrException(
            $getThingConnectedInfoCommand->getId(),
            $getThingConnectedInfoCommand->getThingUsername(),
            $getThingConnectedInfoCommand->getThingPassword()
        );
    }

}