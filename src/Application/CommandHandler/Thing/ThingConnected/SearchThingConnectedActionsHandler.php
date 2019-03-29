<?php

namespace App\Application\CommandHandler\Thing\ThingConnected;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Domain\Repository\ThingConnectedRepository;


class SearchThingConnectedActionsHandler
{

    private $thingConnectedRepository;

    public function __construct(ThingConnectedRepository $thingConnectedRepository)
    {

        $this->thingConnectedRepository = $thingConnectedRepository;
    }

    public function handle(GetThingConnectedInfoCommand $getThingConnectedInfoCommand)
    {
        $id = $getThingConnectedInfoCommand->getId();
        $thing_user_name = $getThingConnectedInfoCommand->getThingUsername();
        $thing_password = $getThingConnectedInfoCommand->getThingPassword();

        return $this->thingConnectedRepository->searchThingActionsByIdOrException($id, $thing_user_name, $thing_password);
    }

}