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

        if ($thingConnected['status'] === true) {
            return [
                'status' => true,
                'data' => ThingConnectedSerializer::serialize($thingConnected['data'])
            ];
        }
        else{
            return $thingConnected;
        }
        // Victor quitar thing (no aporta nada)
        return [
            'thing' => ThingArraySerializer::serialize($thing),
            'thingConnected' => ThingConnectedSerializer::serialize($thing->getThingConnected())
        ];
    }

}