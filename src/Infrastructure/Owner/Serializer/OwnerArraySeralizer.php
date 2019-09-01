<?php

namespace App\Infrastructure\Owner\Serializer;

use App\Domain\Entity\Owner;
use App\Infrastructure\Action\Serializer\ActionArraySerializer;
use App\Infrastructure\Thing\Serializer\ThingArraySerializer;

class OwnerArraySeralizer
{
    public static function serialize(Owner $owner): array
    {
        $ownerArray = [];
        $ownerArray['id'] = $owner->getId();
        $ownerArray['name'] = $owner->getName();

        // Things owned by Owner
        $things = $owner->getThings();
        for ($i = 0; $i < count($things); $i++) {

            $ownerArray['things'][$i] = ThingArraySerializer::serialize($things[$i]);

            $actions = $things[$i]->getActions();
            for ($z = 0; $z < count($actions); $z++) {
                $ownerArray['things'][$i]['actions'] = ActionArraySerializer::serialize($actions[$z]);
            }
        }

        // Friends of owner
        $ownerArray['friendsById'] = $owner->getArrayFiendsIds();
        return $ownerArray;
    }

}