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


    public function getThingConnectedCompleteByIdOrException(int $thingRoot, string $thingUserName, string $thingPassword): array
    {
        $thingConnected = [];
        $thingConnected['message'] = '';

        $data = new stdClass();
        $data->id = $thingRoot;

        $thingConnected['status'] = true;
        $thingConnected['data'] = $this->sendCurlOrException($thingRoot, $thingUserName, $thingPassword);
        return $thingConnected;

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
            // iot_emulator returned 500
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