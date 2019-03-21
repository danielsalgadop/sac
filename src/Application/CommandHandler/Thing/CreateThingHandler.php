<?php

namespace App\Application\CommandHandler\Thing;

use App\Application\Command\Thing\CreateThingCommand;
use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingRepository;

class CreateThingHandler
{
    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function handle(CreateThingCommand $createThingCommand):Thing
    {
        $root = $createThingCommand->getRoot();
        $userName = $createThingCommand->getUserName();
        $password = $createThingCommand->getPassword();

        $thing = new Thing();
        $thing->setRoot($root);
        $thing->setUser($userName);
        $thing->setPassword($password);

        $this->thingRepository->save($thing);
        return $thing;


    }
}
