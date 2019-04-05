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
        return [
            'thing' => ThingArraySerializer::serialize($thing),
            'thingConnected' =>ThingConnectedSerializer::serialize($thing->getThingConnected())
        ];
    }

}