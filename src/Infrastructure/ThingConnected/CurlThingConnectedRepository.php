<?php

namespace App\Infrastructure\ThingConnected;

use App\Domain\Repository\ThingConnectedRepository;


class CurlThingConnectedRepository implements ThingConnectedRepository
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
        if ($json == null) {
            throw new \Exception("Connection Error");
        }
        if (isset($json->error)) {
            throw new \Exception($json->error);
        }
        return json_decode($json);
    }

    public function searchThingByIdOrException(int $id, string $thing_user_name, string $thing_password)
    {
        $thingConnected = $this->sendCurl($id, $thing_user_name, $thing_password);
        if (isset($thingConnected->error)) {
            throw new \Exception("Error while connecting to thing " . $thingConnected->error);
        }
        return $thingConnected;
    }

    public function searchThingNameByIdOrException(int $id, string $thing_user_name, string $thing_password)
    {
        $thingConnected = $this->searchThingByIdOrException($id, $thing_user_name, $thing_password);
        return $thingConnected->name;
    }

    public function searchThingBrandByIdOrException(int $id, string $thing_user_name, string $thing_password)
    {
        $thingConnected = $this->searchThingByIdOrException($id, $thing_user_name, $thing_password);
        return $thingConnected->brand;
    }

    public function searchThingActionsByIdOrException(int $id, string $thing_user_name, string $thing_password)
    {
        $thingConnected = $this->searchThingByIdOrException($id, $thing_user_name, $thing_password);
        return $thingConnected->actions;
        return $thingConnected->actions->actions;
        // DUDA hacer esta transformacion de obj a array
        $actions = [];
//        foreach ($thingConnected->actions as $action){
//            $actions['link'] = $action->link;
//            $actions['resources'] = $action->resources; // DUDA: si hacemos transformacion obj a array, ¿seguir haciendola dentro de cada ->resources?
//        }
        return $actions;
    }
}