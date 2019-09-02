<?php

namespace App\Infrastructure\ThingConnected\Commands;

use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\CommandHandler\Thing\ThingConnected\SearchThingConnectedBrandHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetBrandByThingId extends Command
{
    protected static $defaultName = 'app:ThingConnected:GetThingBrandyThingId';

    private $searchThingByIdHandler;
    private $searchThingConnectedBrandHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler, SearchThingConnectedBrandHandler $searchThingConnectedBrandHandler)
    {
        parent::__construct();
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->searchThingConnectedBrandHandler = $searchThingConnectedBrandHandler;
    }


    protected function configure()
    {
        $this
            ->setDescription('Connects to thing and Brand name')
            ->addArgument('thingId', InputArgument::REQUIRED, 'Thing id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var Thing $thing */
        $thing = $this->searchThingByIdHandler->handle(new SearchThingByIdCommand($input->getArgument('thingId')));
        dd($this->searchThingConnectedBrandHandler->handle(new GetThingConnectedInfoCommand($thing)));
    }
}
