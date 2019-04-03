<?php

namespace App\Infrastructure\Thing\Serializer;

use App\Domain\Entity\Thing;

class ThingArraySerializer
{
    public static function serialize(Thing $thing): array
    {
        return ['id' => $thing->getId(), 'root' => $thing->getRoot()];
    }
}