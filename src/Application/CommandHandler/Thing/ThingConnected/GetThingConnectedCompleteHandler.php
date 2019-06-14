<?php

namespace App\Application\CommandHandler\Thing\ThingConnected;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Domain\Entity\Action;
use App\Domain\Repository\ThingConnectedRepository;
use App\Domain\Entity\Thing;
use App\Infrastructure\Action\MySQLActionRepository;

class GetThingConnectedCompleteHandler
{

    private $thingConnectedRepository;
    private $searchThingByIdHandler;
    /**
     * @var MySQLActionRepository
     */
    private $mySQLActionRepository;

    public function __construct(ThingConnectedRepository $thingConnectedRepository, SearchThingByIdHandler $searchThingByIdHandler, MySQLActionRepository $mySQLActionRepository)
    {
        $this->thingConnectedRepository = $thingConnectedRepository;
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->mySQLActionRepository = $mySQLActionRepository;
    }

    public function handle(GetThingConnectedInfoCommand $getThingConnectedInfoCommand)
    {
        $thingId = $getThingConnectedInfoCommand->getId();

        $thingConnected =  $this->thingConnectedRepository->getThingConnectedCompleteById(
            $thingId,
            $getThingConnectedInfoCommand->getThingUsername(),
            $getThingConnectedInfoCommand->getThingPassword()
        );


        // persistActionToDDBB();
        /** Thing $thing */
        $searchThingByIdCommand = new SearchThingByIdCommand($thingId);
        $thing = $this->searchThingByIdHandler->handle($searchThingByIdCommand);

//        var_export(key($thingConnected['data']->links->actions->resources));
//        dd(gettype($thingConnected['data']->links));
        $actionsInThing = [];
        foreach ($thingConnected['data']->links->actions->resources as $actionName => $action) {
            $this->mySQLActionRepository->save($actionName, $thing);
//            $action = new Action($thing, $actionName);

//                var_export($actionName);
//            $actionsInThing[$actionName] = $action->values;
//            var_export($action);
//            var_export(values($thingConnected['data']->links->actions));
//            dd($action);

        }
        dd($actionsInThing);
        exit;
        dd(gettype($thingConnected['data']->links->actions->resources));




        // sacar del array de thingConnected los actions
//        $thingConnected -> actions


//        $action = new Action();
//        $action->setDescription('');
//        $action->setHttpVerb('');
//        $action->setRoute('');
//        $action->setWt($thing);
//        $action->addFriend($friend);
//
//        $this->manager->persist($action);
//        $arrayActions[] = $action;
//
//
//        $thing->addAction();
//        $thing->flush;  <<<


        return $thingConnected;
    }

}