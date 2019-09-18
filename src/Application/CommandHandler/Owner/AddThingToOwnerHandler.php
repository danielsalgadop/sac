<?php

namespace App\Application\CommandHandler\Owner;

use App\Application\Command\Owner\AddThingToOwnerCommand;
use App\Domain\Entity\Owner;
use App\Domain\Entity\Thing;
//use App\Domain\Repository\OwnerRepository;
use App\Domain\Repository\OwnerRepository;
use App\Infrastructure\Owner\MySQLOwnerRepository;

class AddThingToOwnerHandler
{
    public function __construct(OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function handle(AddThingToOwnerCommand $addThingCommand)
    {
        /** @var Thing $thing */
        $thing = $addThingCommand->getThing();
        /** @var Owner $owner */
        $owner = $addThingCommand->getOwner();
        $owner->addThing($thing);
        $this->ownerRepository->save($owner);
        return $owner;
    }
}
