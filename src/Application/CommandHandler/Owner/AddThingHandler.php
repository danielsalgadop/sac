<?php

namespace App\Application\CommandHandler\Owner;

use App\Application\Command\Owner\AddThingCommand;
use App\Domain\Entity\Owner;
use App\Domain\Entity\Thing;
//use App\Domain\Repository\OwnerRepository;
use App\Infrastructure\Owner\MySQLOwnerRepository;

class AddThingHandler
{
    // TODO: fix. No deberia para aqui MySQLOwnerRepository sino OwnerRepository. Creo
    // que está relacionado con la manera de montar Interfaces y Repositories en este proyecto
    public function __construct(MySQLOwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function handle(AddThingCommand $addThingCommand)
    {
        $thing = $addThingCommand->getThing();
        $owner = $addThingCommand->getOwner();
        $owner->addThing($thing);
        $this->ownerRepository->save($owner);

    }
}