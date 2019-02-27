<?php

namespace App\Application\CommandHandler\Thing;
use App\Application\Command\Thing\getThingNameCommand;

define('ENDPOINT', 'http://localhost');
define('ACTION_PREFIX', 'action_name');



class getThingNameHandler
{
    public function handle(getThingNameCommand $getThingNameCommand)
    {
        $id = $getThingNameCommand->getId();
        $thing_user_name = $getThingNameCommand->getThingUsername();
        $thing_password = $getThingNameCommand->getThingPassword();
        // llamar via curl a iot_emulator
        $json = $this->sendCurl($id,$thing_user_name,$thing_password);
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

    // Mover a ConnectedThingRepository
    function sendCurl($id,$thing_user_name,$thing_password)
    {
        // Esto q es tan variable, definirlo conf/ en parámetros, o hacerlo en services
        $ch = curl_init(ENDPOINT . '/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_PORT, 8001);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'user: '.$thing_user_name,
                'password: '.$thing_password
            )
        );


        $result = curl_exec($ch);
//        file_put_contents("/tmp/get_actions." . $time . ".html", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export($result, true) . PHP_EOL, FILE_APPEND);
//        var_dump($result);
        return $result;
    }


//$json_result_as_array = json_decode(sendCurl($id), true);

}