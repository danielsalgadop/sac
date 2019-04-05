<?php

namespace App\Infrastructure\ThingConnected\Serializer;


class ThingConnectedSerializer
{
    public static function serialize(object $thingConnected): array
    {
        $thingConnectedArray = [];
        // must exist
        $thingConnectedArray['id'] = $thingConnected->id;
        $thingConnectedArray['name'] = $thingConnected->name;
        $thingConnectedArray['brand'] = $thingConnected->brand;
        // may exist
        if($thingConnected->links){
            $thingConnectedArray['links'] = [];
            if($thingConnected->links->actions) { // TODO: tiene sentido que exista key:actions pero NO values?
                $thingConnectedArray['links']['actions'] = [];
                if($thingConnected->links->actions->link) {
                    $thingConnectedArray['links']['actions']['link'] = $thingConnected->links->actions->link;
                }
                if($thingConnected->links->actions->resources) { // TODO: tiene sentido que exista este key, sin valores dentro?
                    $thingConnectedArray['links']['actions']['resources'] = [];
                    foreach ($thingConnected->links->actions->resources as $actionName => $values) {
                        $thingConnectedArray['links']['actions']['resources'][$actionName]['values'] = $values->values;
                    }
                }
            }
        }
        return $thingConnectedArray;
    }

}