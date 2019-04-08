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

    // VICTOR poner type de return  {'status': 'message': data}
    public function getThingConnectedCompleteById(int $id, string $thingUserName, string $thingPassword)
    {
        $thingConnected = new \StdClass();
        $thingConnected->message = '';
        try {
            $curlResponse = $this->sendCurl($id, $thingUserName, $thingPassword);
            $thingConnected->status = true;
            $thingConnected->data = $curlResponse;
        } catch (\Exception $e) {
            $thingConnected->status = false;
            $thingConnected->data = null;
            $thingConnected->message = $e->getMessage();
        }
        return $thingConnected;
    }

    public function searchThingNameByIdOrException(int $id, string $thingUserName, string $thingPassword)
    {
        $thingConnected = $this->getThingConnectedCompleteById($id, $thingUserName, $thingPassword);
//        dd($thingConnected);
        return $thingConnected->data->name;
    }

    public function searchThingBrandByIdOrException(int $id, string $thingUserName, string $thingPassword)
    {
        $thingConnected = $this->getThingConnectedCompleteById($id, $thingUserName, $thingPassword);
        return $thingConnected->data->brand;
    }

    public function searchThingActionsByIdOrException(int $id, string $thingUserName, string $thingPassword)
    {
        return $this->getThingConnectedCompleteById($id, $thingUserName, $thingPassword);
    }
}