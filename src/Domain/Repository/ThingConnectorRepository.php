<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Thing;

class ThingConnectorRepository
{
    const ENDPOINT = 'localhost';
    const PORT = '8001';

    function sendCurl($id, $thing_user_name, $thing_password)
    {
        // Esto q es tan variable, definirlo conf/ en parámetros, o hacerlo en services
        $ch = curl_init(self::ENDPOINT . '/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_PORT, 8001);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'user: ' . $thing_user_name,
                'password: ' . $thing_password
            )
        );


        $json = curl_exec($ch);
        // TODO: esto tiene sentido aqui?
        if($json == null){
            throw new \Exception("Connection Error");
        }
        if(isset($json->error)){
            throw new \Exception($json->error);
        }

//        var_dump($result);
        return json_decode($json);
    }

    public function GetThingByIdOrException(int $id, string $thing_user_name, string $thing_password)
    {
        return $this->sendCurl($id, $thing_user_name, $thing_password);
        if (isset($thingInfo->error)) {
            throw new \Exception("Error while connecting to thing " . $thing->error);
        }
    }

    public function GetThingNameByIdOrException(int $id, string $thing_user_name, string $thing_password)
    {
        $thingInfo = $this->GetThingByIdOrException($id, $thing_user_name, $thing_password);
        return $thingInfo->name;
    }

    public function GetThingBrandByIdOrException(int $id, string $thing_user_name, string $thing_password)
    {
        $thingInfo = $this->GetThingByIdOrException($id, $thing_user_name, $thing_password);
        return $thingInfo->brand;
    }
    public function GetThingActionsByIdOrException(int $id, string $thing_user_name, string $thing_password)
    {
        $thingInfo = $this->GetThingByIdOrException($id, $thing_user_name, $thing_password);
//        dump($thingInfo->actions->actions);
        return $thingInfo->actions->actions;



        // DUDA hacer esta transformacion de obj a array
        $actions = [];

//        foreach ($thingInfo->actions as $action){
//            $actions['link'] = $action->link;
//            $actions['resources'] = $action->resources; // DUDA: si hacemos transformacion obj a array, ¿seguir haciendola dentro de cada ->resources?
//        }
        return $actions;
    }
}