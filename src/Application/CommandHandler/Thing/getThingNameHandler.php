<?php

namespace App\Application\CommandHandler\Thing;

use App\Application\Command\Thing\getThingNameCommand;
use App\Domain\Repository\ThingConnectorRepository;


class getThingNameHandler
{
    public function handle(getThingNameCommand $getThingNameCommand, ThingConnectorRepository $ThingConnectorRepository)
    {
        $id = $getThingNameCommand->getId();
        $thing_user_name = $getThingNameCommand->getThingUsername();
        $thing_password = $getThingNameCommand->getThingPassword();
        // llamar via curl a iot_emulator
        $thingInfo = $ThingConnectorRepository->GetThingByIdOrException($id, $thing_user_name, $thing_password);
//        $result = json_decode($json);
        $this->throwExceptionIfError($thingInfo);
        return $thingInfo->name;
    }

    function throwExceptionIfError(object $thingInfo)
    {
        if (isset($thingInfo->error)) {
            throw new \Exception("Error while connecting to thing " . $thing->error);
        }

    }


//$json_result_as_array = json_decode(sendCurl($id), true);

}