<?php

namespace App\Infrastructure\Owner\Command;


use App\Application\Command\Action\SearchActionByIdCommand;
use App\Application\Command\Friend\SearchFriendByIdCommand;
use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Action\SearchActionByIdHandler;
use App\Application\CommandHandler\Friend\SearchFriendByIdHandler;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Application\Command\Owner\ShareActionWithFriendCommand;
use App\Application\CommandHandler\Owner\ShareActionWithFriendHandler;

class ShareActionWithFriend extends Command
{
    protected static $defaultName = "app:Owner:ShareActionToFriend";

    private $searchOwnerByFbDelegatedHandler;
    private $searchFriendByIdHandler;
    private $searchActionByIdHandler;
    private $shareActionWithFriendHandler;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler, SearchFriendByIdHandler $searchFriendByIdHandler, SearchActionByIdHandler $searchActionByIdHandler, ShareActionWithFriendHandler $shareActionWithFriendHandler)
    {
        parent::__construct();
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
        $this->searchFriendByIdHandler = $searchFriendByIdHandler;
        $this->searchActionByIdHandler = $searchActionByIdHandler;
        $this->shareActionWithFriendHandler = $shareActionWithFriendHandler;
    }


    protected function configure()
    {
        $this
            ->setDescription("Given an owner fbDelegated, a Friend ID and ActionId. Shares Given Action to Friend")
            ->addArgument('ownerFbDelegated', InputArgument::REQUIRED, 'fb_delegated of Owner (must exist)')
            ->addArgument('friendId', InputArgument::REQUIRED, 'id of Friend (must exist)')
            ->addArgument('actionId', InputArgument::REQUIRED, 'id of Action (must exist)')
            ;
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ownerFbDelegated = $input->getArgument('ownerFbDelegated');
        $friendId = $input->getArgument('friendId');
        $actionId = $input->getArgument('actionId');

        $action = $this->searchActionByIdHandler->handle(new SearchActionByIdCommand($actionId));
        $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($ownerFbDelegated));
        $friend = $this->searchFriendByIdHandler->handle(new SearchFriendByIdCommand($friendId));


        $this->shareActionWithFriendHandler->handle(new ShareActionWithFriendCommand($owner,$friend,$action));
    }
}