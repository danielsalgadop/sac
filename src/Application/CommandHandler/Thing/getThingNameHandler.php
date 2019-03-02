<?php

namespace App\Application\CommandHandler\Thing;

use App\Application\Command\Thing\getThingNameCommand;
use App\Domain\Repository\ThingConnectorRepository;


class getThingNameHandler
{
    public function handle(getThingNameCommand $getThingNameCommand, ThingConnectorRepository $ThingConnectorRepository )
    {
        $id = $getThingNameCommand->getId();
        $thing_user_name = $getThingNameCommand->getThingUsername();
        $thing_password = $getThingNameCommand->getThingPassword();
        // llamar via curl a iot_emulator
        $json =  $ThingConnectorRepository->sendCurl($id,$thing_user_name,$thing_password);
        $result = json_decode($json);
        $this->throwExceptionIfError($result);
        var_dump($result);
        return $result->name;
    }

    function throwExceptionIfError(object $result)
    {
        if(isset($result->error)){
            throw new \Exception("Error while connecting to thing ".$thing->error);
        }

    }



//$json_result_as_array = json_decode(sendCurl($id), true);

}