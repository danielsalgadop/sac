<?php

namespace App\Infrastructure\Thing\Serializer;

use App\Domain\Entity\Thing;
use App\Infrastructure\Thing\Serializer\ThingArraySerializer;
use App\Infrastructure\Action\Serializer\ActionArraySerializer;
use App\Infrastructure\ThingConnected\Serializer\ThingConnectedSerializer;
use function PHPSTORM_META\type;

class ThingWithThingConnectedArraySerializer
{
    public static function serialize(Thing $thing): array
    {
        $thingConnected = $thing->getThingConnected();


        if ( array_key_exists("error", $thingConnected)) {
            return [
                'status' => false,
                'message' => $thingConnected['error'],
                'data' => null,
            ];
        } else {

            return [
                'status' => true,
                'message' => null,
                'data' => ThingConnectedSerializer::serialize($thingConnected['data'])
            ];
        }
    }

}