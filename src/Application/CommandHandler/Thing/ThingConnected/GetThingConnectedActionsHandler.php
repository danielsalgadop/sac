<?php

namespace App\Application\CommandHandler\Thing\ThingConnected;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Domain\Repository\ThingConnectorRepository;


class GetThingConnectedActionsHandler
{
    public function handle(GetThingConnectedInfoCommand $GetThingConnectedInfoCommand, ThingConnectorRepository $ThingConnectorRepository)
    {
        $id = $GetThingConnectedInfoCommand->getId();
        $thing_user_name = $GetThingConnectedInfoCommand->getThingUsername();
        $thing_password = $GetThingConnectedInfoCommand->getThingPassword();

        return $ThingConnectorRepository->GetThingActionsByIdOrException($id, $thing_user_name, $thing_password);
    }

}