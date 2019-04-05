<?php

namespace App\Infrastructure\Thing\Command;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\CommandHandler\Thing\ThingConnected\SearchThingConnectedCompleteHandler;


class MergeThingWithThingConnectedById extends Command
{
    protected static $defaultName = 'app:Thing:MergeThingWithThingConnectedById';
    private $searchThingByIdHandler;
    private $searchThingConnectedCompleteHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler, SearchThingConnectedCompleteHandler $searchThingConnectedCompleteHandler)
    {
        parent::__construct();
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->searchThingConnectedCompleteHandler = $searchThingConnectedCompleteHandler;
    }

    protected function configure()
    {
        $this
            ->setDescription('Given and (int) id searches Thing')
            ->addArgument('thingId', InputArgument::REQUIRED, '(int) thing id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $thing = $this->searchThingByIdHandler->handle(new SearchThingByIdCommand($input->getArgument('thingId')));
        $thingConnected = $this->searchThingConnectedCompleteHandler->handle(new GetThingConnectedInfoCommand($thing->getId(), $thing->getUser(), $thing->getPassword()));
        $thing->thingConnected = $thingConnected;
        dd($thing);
    }
}
