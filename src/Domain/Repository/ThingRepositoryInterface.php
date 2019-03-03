<?php


namespace App\Domain\Repository;
use App\Domain\Entity\Thing;


interface ThingRepositoryInterface
{
    public function save(Thing $thing);
}
