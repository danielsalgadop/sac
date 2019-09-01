<?php

namespace App\Infrastructure\Owner\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\Command\Owner\AddThingToOwnerCommand;
use App\Application\CommandHandler\Owner\AddThingToOwnerHandler;

class AddThingToOwner extends Command
{
    protected static $defaultName = 'app:Owner:AddThingToOwner';
    private $searchOwnerByFbDelegatedHandler;
    private $addThingToOwnerHandler;
    private $searchThingByIdHandler;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler, SearchThingByIdHandler $searchThingByIdHandler, AddThingToOwnerHandler $addThingToOwnerHandler)
    {
        parent::__construct();

        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->addThingToOwnerHandler = $addThingToOwnerHandler;
    }


    protected function configure()
    {
        $this
            ->setDescription('Given fbDelegated of Owner and Thing id  will create a relationship in owner_thing table')
            ->addArgument('OwnerFbDelegated', InputArgument::REQUIRED, 'fb_delegated of Owner (must exist)')
            ->addArgument('thingId', InputArgument::REQUIRED, 'Thing Id (must exist)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($input->getArgument('OwnerFbDelegated')));
        $thing = $this->searchThingByIdHandler->handle(new SearchThingByIdCommand($input->getArgument('thingId')));
        $this->addThingToOwnerHandler->handle(new AddThingToOwnerCommand($thing, $owner));

        $io->success('Thing [' . $thing->getId() . '] added to Owner [' . $owner->getName() . ']');
    }
}
