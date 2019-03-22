<?php

namespace App\Application\CommandHandler\Owner;

use App\Application\Command\Owner\GetListThingsByOwnerCommand;
use App\Domain\Entity\Thing;
use App\Domain\Repository\OwnerRepository;

class GetListThingsByOwnerHandler
{
//    public function __construct(OwnerRepository $ownerRepository)
//    {
//        $this->ownerRepository = $ownerRepository;
//    }

    // TODO: determine return type. If file named List must return a list?
    public function handle(GetListThingsByOwnerCommand $getListThingsByOwnerCommand):array
    {
        $owner = $getListThingsByOwnerCommand->getOwner();

        $things = [];
        foreach ($owner->getThings() as $thing){
            $things[] = $thing;
        }
        return $things;
        $things = $owner->getThings();
        return $things;
    }
}