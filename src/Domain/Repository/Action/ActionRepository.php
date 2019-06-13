<?php


namespace App\Domain\Repository\Action;

//use App\Domain\Entity\Action;


use App\Domain\Entity\Friend;
use App\Domain\Entity\Thing;

interface ActionRepository
{


    public function save(string $route, Thing $thing);
//    public function searchByfbDelegated(string $fbDelegated);
//    public function searchById(int $id);  // actually not in use, created just-in-case
}
