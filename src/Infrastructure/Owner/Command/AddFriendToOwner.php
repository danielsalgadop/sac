<?php

namespace App\Infrastructure\Owner\Command;

use App\Application\Command\Owner\AddFriendToOwnerCommand;
use App\Application\CommandHandler\Owner\AddFriendToOwnerHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use App\Application\Command\Friend\SearchFriendByFbDelegatedCommand;
use App\Application\CommandHandler\Friend\SearchFriendByFbDelegatedHandler;

class AddFriendToOwner extends Command
{
    protected static $defaultName = 'app:Owner:AddFriendToOwner';
    private $searchOwnerByFbDelegatedHandler;
    private $searchFriendByFbDelegatedHandler;
    private $addFriendToOwnerHandler;

    public function __construct (SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler, SearchFriendByFbDelegatedHandler $searchFriendByFbDelegatedHandler, AddFriendToOwnerHandler $addFriendToOwnerHandler)
    {
        parent::__construct();
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
        $this->searchFriendByFbDelegatedHandler = $searchFriendByFbDelegatedHandler;
        $this->addFriendToOwnerHandler = $addFriendToOwnerHandler;
    }


    protected function configure()
    {
        $this
            ->setDescription('Given fbDelegated of Owner and fbDelegated of Friend will create a relationshing in owner_friend table')
            ->addArgument('OwnerFbDelegated', InputArgument::REQUIRED, 'fb_delegated of Owner (must exist)')
            ->addArgument('FriendFbDelegated', InputArgument::REQUIRED, 'fb_delegated of Friend (must exist)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($input->getArgument('OwnerFbDelegated')));

        $friend = $this->searchFriendByFbDelegatedHandler->handle(new SearchFriendByFbDelegatedCommand($input->getArgument('FriendFbDelegated')));

        $owner = $this->addFriendToOwnerHandler->handle(new AddFriendToOwnerCommand($friend, $owner));

        $io->success('Friend ['.$friend->getFbDelegated().'] added to Owner ['.$owner->getName().']');
    }
}
