<?php

namespace App\Infrastructure\Thing\Command;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\CommandHandler\Thing\MergeThingWithThingConnectedByIdHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\Command\Thing\MergeThingWithThingConnectedByIdCommand;
use App\Application\CommandHandler\Thing\ThingConnected\SearchThingConnectedCompleteHandler;

class MergeThingWithThingConnectedById extends Command
{
    protected static $defaultName = 'app:Thing:MergeThingWithThingConnectedById';
    private $mergeThingWithThingConnectedByIdHandler;

    public function __construct(MergeThingWithThingConnectedByIdHandler $mergeThingWithThingConnectedByIdHandler)
    {
        parent::__construct();
        $this->mergeThingWithThingConnectedByIdHandler = $mergeThingWithThingConnectedByIdHandler;
    }

    protected function configure()
    {
        $this
            ->setDescription('Given and (int) id searches Thing')
            ->addArgument('thingId', InputArgument::REQUIRED, '(int) thing id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
//        $thing = $this->searchThingByIdHandler->handle(new SearchThingByIdCommand($input->getArgument('thingId')));
//        $thingConnected = $this->searchThingConnectedCompleteHandler->handle(new GetThingConnectedInfoCommand($thing->getId(), $thing->getUser(), $thing->getPassword()));
//        $thing->thingConnected = $thingConnected;
        dd($this->mergeThingWithThingConnectedByIdHandler->handle(new MergeThingWithThingConnectedByIdCommand($input->getArgument('thingId'))));
    }
}
