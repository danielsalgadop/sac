<?php

namespace App\Domain\Repository;


interface ThingConnectedRepository
{
    public function getThingConnectedById(int $id, string $thing_user_name, string $thing_password);
    public function searchThingNameByIdOrException(int $id, string $thing_user_name, string $thing_password);
    public function searchThingBrandByIdOrException(int $id, string $thing_user_name, string $thing_password);
    public function searchThingActionsByIdOrException(int $id, string $thing_user_name, string $thing_password);
}