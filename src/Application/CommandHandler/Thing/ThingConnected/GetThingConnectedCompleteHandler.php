<?php

namespace App\Application\CommandHandler\Thing\ThingConnected;

use App\Application\Command\Action\CreateActionCommand;
use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\CommandHandler\Action\CreateActionHandler;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingConnectedRepository;
use App\Infrastructure\Action\MySQLActionRepository;
use \Exception;

class GetThingConnectedCompleteHandler
{

    private $thingConnectedRepository;
    private $searchThingByIdHandler;
    private $createActionHandler;

    /**
     * @var MySQLActionRepository
     */
    private $mySQLActionRepository;  // TODO    OOOOOOOOOOOO deberia ser la interfaz

    public function __construct(ThingConnectedRepository $thingConnectedRepository, SearchThingByIdHandler $searchThingByIdHandler, MySQLActionRepository $mySQLActionRepository, CreateActionHandler $createActionHandler)
    {
        $this->thingConnectedRepository = $thingConnectedRepository;
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->mySQLActionRepository = $mySQLActionRepository;
        $this->createActionHandler = $createActionHandler;
    }

    public function handle(GetThingConnectedInfoCommand $getThingConnectedInfoCommand)
    {
        /* @var Thing $thing */
        $thing = $getThingConnectedInfoCommand->getThing();
        $thingConnected = $this->thingConnectedRepository->getThingConnectedCompleteByIdOrException($thing->getRoot(), $thing->getUser(), $thing->getPassword());

        if (isset($thingConnected['data']->links->actions->resources)) {
            foreach ($thingConnected['data']->links->actions->resources as $actionName => $action) {
                $action = $this->createActionHandler->handle(
                    new CreateActionCommand(
                        $thing,
                        $actionName
                    )
                );
            }
        } else {
            throw new Exception('Invalid Credentials');
        }


        return $thingConnected;
    }

}