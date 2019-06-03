<?php

namespace App\Infrastructure\Thing\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;


class SearchById extends Command
{
    // TODO: rename as SearchThingByThingId
    protected static $defaultName = 'app:Thing:SearchByThingId';
    private $searchThingByIdHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler)
    {
        parent::__construct();
        $this->searchThingByIdHandler = $searchThingByIdHandler;
    }

    protected function configure()
    {
        $this
            ->setDescription('Given a (int) id searches Thing')
            ->addArgument('thingId', InputArgument::REQUIRED, '(int) thing id')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $thing = $this->searchThingByIdHandler->handle(new SearchThingByIdCommand($input->getArgument('thingId')));
        dd($thing);
    }
}
