<?php

namespace App\Infrastructure\Action\Command;

use App\Application\Command\Action\CreateActionCommand;
use App\Application\CommandHandler\Action\CreateActionHandler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\Command\Friend\SearchFriendByFbDelegatedCommand;
use App\Application\CommandHandler\Friend\SearchFriendByFbDelegatedHandler;


class Create extends ContainerAwareCommand
{
    protected static $defaultName = 'app:Action:Create';
    private $searchThingByIdHandler;
    private $searchFriendByFbDelegatedHandler;
    private $createActionHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler, SearchFriendByFbDelegatedHandler $searchFriendByFbDelegatedHandler, CreateActionHandler $createActionHandler)
    {
        parent::__construct();
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->searchFriendByFbDelegatedHandler = $searchFriendByFbDelegatedHandler;
        $this->createActionHandler = $createActionHandler;
    }

    protected function configure()
    {
        $this
            ->setDescription('Given thingId and actionName Creates an Action')
            ->addArgument('thingId', InputArgument::REQUIRED, '(int) thing id')
            ->addArgument('name', InputArgument::REQUIRED, '(string) name')  // this acctionName matches really this is action name (links->actions->link->resources)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        // HC will be Command Arguments

        // Thing
        $thing = $this->searchThingByIdHandler->handle(new SearchThingByIdCommand($input->getArgument("thingId")));

        // Friend
//        $friend = $this->searchFriendByFbDelegatedHandler->handle(new SearchFriendByFbDelegatedCommand($input->getArgument("friendFbDelegated")));

        $action = $this->createActionHandler->handle(
            new CreateActionCommand(
                $thing,
                $input->getArgument("name")
            )
        );

        $io->success('Created Action [' . $action->getId() . '] with name (actionName) [' . $action->getName() . ']for ThingId [' . $thing->getId() . ']');
    }
}
