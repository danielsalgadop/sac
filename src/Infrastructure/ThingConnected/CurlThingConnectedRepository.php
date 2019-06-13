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
        elseif (curl_getinfo($ch)['http_code'] === 500){
            throw new \Exception('iot_emulator Internal Error');
        }

        // possible json_decode errors
        $jsonDecoded = json_decode($json);
        if (isset($jsonDecoded->error)) {
            throw new \Exception($jsonDecoded->error);
        }
        return json_decode($json);
    }

    // VICTOR poner type de return  {'status': 'message': data}
    public function getThingConnectedCompleteById(int $id, string $thingUserName, string $thingPassword): array
    {
//        dd("sdafsd");
//        $thingConnected = new \StdClass();  // antes era objeto, ahora array
        $thingConnected = [];
        $thingConnected['message'] = '';

        // default $data content, just with thingId
        $data = new \stdClass();
        $data->id = $id;

        try {
            $curlResponse = $this->sendCurl($id, $thingUserName, $thingPassword);
            if ($curlResponse === null) { // problems in iot_emulator response
                $thingConnected['status'] = false;
                $thingConnected['data'] = null;
                $thingConnected['message'] = 'ThingConnected internal errors '.$curlResponse->message;
//                var_export($thingConnected);die;
//                dd($thingConnected);
                return $thingConnected;
//                throw new \Exception($curlResponse->message);
            } else {

                $thingConnected['status'] = true;
                $thingConnected['data'] = $curlResponse;
            }
        } catch (\Exception $e) { // problems during connection or Credentials
            $thingConnected['status'] = false;
            $thingConnected['data'] = $data;
            $thingConnected['message'] = $e->getMessage();
        }
        return $thingConnected;
    }

    public function searchThingNameByIdOrException(int $id, string $thingUserName, string $thingPassword)
    {
        $thingConnected = $this->getThingConnectedCompleteById($id, $thingUserName, $thingPassword);
//        dd($thingConnected);
        if ($thingConnected->status === true) {
            return $thingConnected->data->name;
        }
        throw new \Exception($thingConnected->message);
//        dd($thingConnected);
    }

    public function searchThingBrandByIdOrException(int $id, string $thingUserName, string $thingPassword)
    {
        $thingConnected = $this->getThingConnectedCompleteById($id, $thingUserName, $thingPassword);
        return $thingConnected->data->brand;
    }

    public function searchThingActionsByIdOrException(int $id, string $thingUserName, string $thingPassword)
    {
        $thingConnected = $this->getThingConnectedCompleteById($id, $thingUserName, $thingPassword);
        dd($thingConnected);
        return $thingConnected->data->actions;
    }

}