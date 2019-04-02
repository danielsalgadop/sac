<?php

namespace App\Infrastructure\ThingConnected;

use App\Domain\Repository\ThingConnectedRepository;


class CurlThingConnectedRepository implements ThingConnectedRepository
{
//    private $endpoint = "localhost";
//    private $port = "8001";

    private $endpoint;
    private $port;


//    public function __construct(string $endpoint, int $port)
    public function __construct()
//    public function __construct(string $endpoint)
    {

//        $this->endpoint = $endpoint;
        $this->endpoint = "localhost";
        $this->port = 8001;
//        $this->port = $port;
    }

    private function sendCurl($id, $thingUserName, $thingPassword)
    {
        // TODO VICTOR: endpoint y puerto pasarlo como parámetro al constructor. Definirlo en parámetros y en services, Usarlo como servicio la url y el puerto
        // Esto q es tan variable, definirlo conf/ en parámetros, o hacerlo en services
        $ch = curl_init($this->endpoint . '/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_PORT, $this->port);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'user: ' . $thingUserName,
                'password: ' . $thingPassword
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

    public function searchThingByIdOrException(int $id, string $thingUserName, string $thingPassword)
    {
        $thingConnected = $this->sendCurl($id, $thingUserName, $thingPassword);
        if (isset($thingConnected->error)) {
            throw new \Exception("Error while connecting to thing " . $thingConnected->error);
        }
        return $thingConnected;
    }

    public function searchThingNameByIdOrException(int $id, string $thingUserName, string $thingPassword)
    {
        $thingConnected = $this->searchThingByIdOrException($id, $thingUserName, $thingPassword);
        return $thingConnected->name;
    }

    public function searchThingBrandByIdOrException(int $id, string $thingUserName, string $thingPassword)
    {
        $thingConnected = $this->searchThingByIdOrException($id, $thingUserName, $thingPassword);
        return $thingConnected->brand;
    }

    public function searchThingActionsByIdOrException(int $id, string $thingUserName, string $thingPassword)
    {
        $thingConnected = $this->searchThingByIdOrException($id, $thingUserName, $thingPassword);
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