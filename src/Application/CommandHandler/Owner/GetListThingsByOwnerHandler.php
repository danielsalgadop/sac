<?php

namespace App\Application\CommandHandler\Owner;

use App\Application\Command\Owner\GetListThingsByOwnerCommand;
use App\Domain\Entity\Owner;

class GetListThingsByOwnerHandler
{
    public function handle(GetListThingsByOwnerCommand $getListThingsByOwnerCommand):array
    {
        /** @var Owner $owner */
        $owner = $getListThingsByOwnerCommand->getOwner();

        $things = [];
        foreach ($owner->getThings() as $thing){
            $things[] = $thing;
        }
        return $things;
    }
}