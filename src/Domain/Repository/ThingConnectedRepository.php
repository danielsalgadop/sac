<?php

namespace App\Domain\Repository;


interface ThingConnectedRepository
{
    public function getThingConnectedCompleteByIdOrException(int $thingRoot, string $thingUserName, string $thingPasssword);

    public function searchThingNameByIdOrException(int $thingRoot, string $thingUserName, string $thingPasssword);

    public function searchThingBrandByIdOrException(int $thingRoot, string $thingUserName, string $thingPasssword);

    public function searchThingActionsByIdOrException(int $thingRoot, string $thingUserName, string $thingPasssword);
}