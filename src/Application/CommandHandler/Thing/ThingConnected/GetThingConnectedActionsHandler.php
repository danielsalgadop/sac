<?php

namespace App\Application\CommandHandler\Thing\ThingConnected;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Domain\Repository\ThingConnectorRepository;


class GetThingConnectedActionsHandler
{
    public function handle(GetThingConnectedInfoCommand $getThingConnectedInfoCommand, ThingConnectorRepository $ThingConnectorRepository)
    {
        $id = $getThingConnectedInfoCommand->getId();
        $thing_user_name = $getThingConnectedInfoCommand->getThingUsername();
        $thing_password = $getThingConnectedInfoCommand->getThingPassword();

        return $ThingConnectorRepository->GetThingActionsByIdOrException($id, $thing_user_name, $thing_password);
    }

}