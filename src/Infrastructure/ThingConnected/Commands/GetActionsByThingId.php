<?php

namespace App\Infrastructure\ThingConnected\Commands;

use App\Domain\Entity\Thing;
use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\CommandHandler\Thing\ThingConnected\SearchThingConnectedActionsHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetActionsByThingId extends Command
{
    protected static $defaultName = 'app:ThingConnected:GetThingActionsByThingId';

    private $searchThingByIdHandler;
    private $searchThingConnectedActionsHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler, SearchThingConnectedActionsHandler $searchThingConnectedActionsHandler)
    {
        parent::__construct();
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->searchThingConnectedActionsHandler = $searchThingConnectedActionsHandler;
    }


    protected function configure()
    {
        $this
            ->setDescription('Connects to thing and retrieves Actions name')
            ->addArgument('thingId', InputArgument::REQUIRED, 'Thing id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var Thing $thing */
        $thing = $this->searchThingByIdHandler->handle(new SearchThingByIdCommand($input->getArgument('thingId')));
        dd($this->searchThingConnectedActionsHandler->handle(new GetThingConnectedInfoCommand($thing)));
    }
}
