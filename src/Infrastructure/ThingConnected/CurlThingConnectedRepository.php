<?php

namespace App\Infrastructure\ThingConnected;

use App\Domain\Repository\ThingConnectedRepository;
use Exception;
use stdClass;


class CurlThingConnectedRepository implements ThingConnectedRepository
{

    private $iotEmulatorHost;
    private $iotEmulatorPort;

    public function __construct()
    {
        $this->iotEmulatorHost = getenv('IOT_EMULATOR_HOST');
        $this->iotEmulatorPort = getenv('IOT_EMULATOR_PORT');
    }

    public function searchThingNameByIdOrException(int $thingRoot, string $thingUserName, string $thingPassword)
    {
        $thingConnected = $this->getThingConnectedCompleteByIdOrException($thingRoot, $thingUserName, $thingPassword);
        return $thingConnected['data']->name;
    }

    // VICTOR poner type de return  {'status': 'message': data}

    public function getThingConnectedCompleteByIdOrException(int $thingRoot, string $thingUserName, string $thingPassword): array
    {
//        dd("sdafsd");
//        $thingConnected = new \StdClass();  // antes era objeto, ahora array
        $thingConnected = [];
        $thingConnected['message'] = '';

        // default $data content, just with thingId
        $data = new stdClass();
        $data->id = $thingRoot;

        $thingConnected['status'] = true;
        $thingConnected['data'] = $this->sendCurlOrException($thingRoot, $thingUserName, $thingPassword);
        return $thingConnected;

//        try {
        $curlResponse = $this->sendCurlOrException($thingRoot, $thingUserName, $thingPassword);
        if ($curlResponse === null) { // problems in iot_emulator response
            throw new Exception('ThingConnected null response ' . $curlResponse->message);
//                $thingConnected['status'] = false;
//                $thingConnected['data'] = null;
//                $thingConnected['message'] = ;
//                var_export($thingConnected);die;
//                dd($thingConnected);
//                return $thingConnected;
//                throw new Exception($curlResponse->message);
        } else {

            $thingConnected['status'] = true;
            $thingConnected['data'] = $curlResponse;
            return $thingConnected;
        }
//        } catch (Exception $e) { // problems during connection or Credentials

//            $thingConnected['status'] = false;
//            $thingConnected['data'] = $data;
//            $thingConnected['message'] = $e->getMessage();
//        }
//        return $thingConnected;
    }

    private function sendCurlOrException($thingRoot, $thingUserName, $thingPassword)
    {
        $ch = curl_init($this->iotEmulatorHost . '/' . $thingRoot);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_PORT, $this->iotEmulatorPort);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'user: ' . $thingUserName,
                'password: ' . $thingPassword
            )
        );

        $json = curl_exec($ch);
        if ($json == null) {
            throw new Exception("Connection Error");
        }

        $jsonDecoded = @json_decode($json);
        // possible json_decode errors
        if ($jsonDecoded == null) {
            throw new Exception("invalid json format");

        } elseif (isset($jsonDecoded->error)) {
            // iot_emulator returned error
            throw new Exception($jsonDecoded->error);
        } elseif (curl_getinfo($ch)['http_code'] === 500) {
            // iot_emulatro returned 500
            throw new Exception('iot_emulator Internal Error');
        }


        return $jsonDecoded;
    }

    public function searchThingBrandByIdOrException(int $thingRoot, string $thingUserName, string $thingPassword)
    {
        $thingConnected = $this->getThingConnectedCompleteByIdOrException($thingRoot, $thingUserName, $thingPassword);
        return $thingConnected['data']->brand;
    }

    public function searchThingActionsByIdOrException(int $thingRoot, string $thingUserName, string $thingPassword)
    {
        $thingConnected = $this->getThingConnectedCompleteByIdOrException($thingRoot, $thingUserName, $thingPassword);
        return $thingConnected['data']->links->actions->resources;
    }

}