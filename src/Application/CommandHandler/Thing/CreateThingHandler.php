<?php

namespace App\Application\CommandHandler\Thing;

use App\Application\Command\Thing\CreateThingCommand;
use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingRepositoryInterface;

class CreateThingHandler
{
    public function __construct(ThingRepositoryInterface $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function handle(CreateThingCommand $createThingCommand)
    {
        $root = $createThingCommand->getRoot();
        $userName = $createThingCommand->getUserName();
        $password = $createThingCommand->getPassword();

        $thing = new Thing();
        $thing->setRoot($root);
        $thing->setUser($userName);
        $thing->setPassword($password);

        return $this->thingRepository->save($thing);

    }
}
