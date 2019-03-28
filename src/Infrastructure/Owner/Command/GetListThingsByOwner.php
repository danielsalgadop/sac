<?php

namespace App\Infrastructure\Owner\Command;

use App\Application\Command\Owner\GetListThingsByOwnerCommand;
use App\Application\CommandHandler\Owner\GetListThingsByOwnerHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;

class GetListThingsByOwner extends Command
{
    protected static $defaultName = 'app:Owner:GetListThingsByOwner';
    private $searchOwnerByFbDelegatedHandler;
    private $getListThingsByOwnerHandler;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler, GetListThingsByOwnerHandler $getListThingsByOwnerHandler)
    {
        parent::__construct();
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
        $this->getListThingsByOwnerHandler = $getListThingsByOwnerHandler;
    }


    protected function configure()
    {
        $this
            ->setDescription('Given an fb_delegated returns list of things')
            ->addArgument('ownerFbDelegated', InputArgument::REQUIRED, '(string) fb_delegated')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($input->getArgument('ownerFbDelegated')));

        $things = $this->getListThingsByOwnerHandler->handle(new GetListThingsByOwnerCommand($owner));
        dd($things);
    }
}
