<?php

namespace App\Infrastructure\ThingConnected\Commands;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\CommandHandler\Thing\ThingConnected\GetThingConnectedCompleteHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\Command\Thing\SearchThingByIdCommand;

class GetThingConnectedById extends Command
{
    protected static $defaultName = 'app:ThingConnected:GetThingConnectedCompleteById';

    private $searchThingByIdHandler;
    private $searchThingConnectedCompleteHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler, GetThingConnectedCompleteHandler $searchThingConnectedCompleteHandler)
    {
        parent::__construct();
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->searchThingConnectedCompleteHandler = $searchThingConnectedCompleteHandler;
    }


    protected function configure()
    {
        $this
            ->setDescription('Connects to thing and retrieves All ThingConnected Info')
            ->addArgument('thingId', InputArgument::REQUIRED, 'Thing id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $thing = $this->searchThingByIdHandler->handle(
            new SearchThingByIdCommand(
                $input->getArgument('thingId')
            )
        );

        dd(
            $this->searchThingConnectedCompleteHandler->handle(
                new GetThingConnectedInfoCommand($thing)
            )
        );
    }
}
