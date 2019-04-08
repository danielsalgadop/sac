<?php

namespace App\Infrastructure\ThingConnected\Commands;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\CommandHandler\Thing\ThingConnected\SearchThingConnectedNameHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetNameByThingId extends Command
{
    protected static $defaultName = 'app:ThingConnected:GetThingNameByThingId';

    private $searchThingByIdHandler;
    private $searchThingConnectedNameHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler, SearchThingConnectedNameHandler $searchThingConnectedNameHandler)
    {
        parent::__construct();
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->searchThingConnectedNameHandler = $searchThingConnectedNameHandler;
    }


    protected function configure()
    {
        $this
            ->setDescription('Connects to thing and retrieves name')
            ->addArgument('thingId', InputArgument::REQUIRED, 'Thing id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $thing = $this->searchThingByIdHandler->handle(new SearchThingByIdCommand($input->getArgument('thingId')));
        dd($this->searchThingConnectedNameHandler->handle(new GetThingConnectedInfoCommand($thing->getId(), $thing->getUser(), $thing->getPassword())));
    }
}
