<?php

namespace App\Application\CommandHandler\Thing\ThingConnected;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\Command\Action\CreateActionCommand;
use App\Application\CommandHandler\Action\CreateActionHandler;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Domain\Repository\ThingConnectedRepository;
use App\Infrastructure\Action\MySQLActionRepository;

class GetThingConnectedCompleteHandler
{

    private $thingConnectedRepository;
    private $searchThingByIdHandler;
    private $createActionHandler;
    /**
     * @var MySQLActionRepository
     */
    private $mySQLActionRepository;  // deberia ser la interfaz

    public function __construct(ThingConnectedRepository $thingConnectedRepository, SearchThingByIdHandler $searchThingByIdHandler, MySQLActionRepository $mySQLActionRepository, CreateActionHandler $createActionHandler)
    {
        $this->thingConnectedRepository = $thingConnectedRepository;
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->mySQLActionRepository = $mySQLActionRepository;
        $this->createActionHandler = $createActionHandler;
    }

    public function handle(GetThingConnectedInfoCommand $getThingConnectedInfoCommand)
    {
        $thingId = $getThingConnectedInfoCommand->getId();

        $thingConnected =  $this->thingConnectedRepository->getThingConnectedCompleteByIdOrException(
            $thingId,
            $getThingConnectedInfoCommand->getThingUsername(),
            $getThingConnectedInfoCommand->getThingPassword()
        );


        // persistActionToDDBB();
        /** Thing $thing */
        $searchThingByIdCommand = new SearchThingByIdCommand($thingId);
        $thing = $this->searchThingByIdHandler->handle($searchThingByIdCommand);

        $actionsInThing = [];
        foreach ($thingConnected['data']->links->actions->resources as $actionName => $action) {


        $action = $this->createActionHandler->handle(
            new CreateActionCommand(
                $thing,
                $actionName
            )
        );


        }



        return $thingConnected;
    }

}