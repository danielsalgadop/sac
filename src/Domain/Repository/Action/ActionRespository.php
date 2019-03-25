<?php


namespace App\Domain\Repository\Action;

//use App\Domain\Entity\Action;


use App\Domain\Entity\Friend;
use App\Domain\Entity\Thing;

interface ActionRespository
{


    public function save(string $httpVerb, string $route, Thing $thing, Friend $friend, string $actionDescription);
//    public function searchByfbDelegated(string $fbDelegated);
//    public function searchById(int $id);  // actually not in use, created just-in-case
}
