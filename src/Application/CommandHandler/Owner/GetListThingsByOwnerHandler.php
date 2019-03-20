<?php

namespace App\Application\CommandHandler\Owner;

use App\Application\Command\Thing\GetListThingsByOwnerCommand;
use App\Domain\Entity\Thing;
use App\Domain\Repository\OwnerRepository;

class GetListThingsByOwnerHandler
{
    public function __construct(OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function handle(GetListThingsByOwnerCommand $getListThingsByOwnerCommand):Thing
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