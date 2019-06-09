<?php

namespace App\Infrastructure\Action\Command;

use App\Application\CommandHandler\Action\CreateActionHandler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\Command\Friend\SearchFriendByFbDelegatedCommand;
use App\Application\CommandHandler\Friend\SearchFriendByFbDelegatedHandler;


class FindActionsByFriend extends ContainerAwareCommand
{
    protected static $defaultName = 'app:Action:FindActionsByFriend';
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
            ->setDescription('Returns array of Actions')
            ->addArgument('friendFbDelegated', InputArgument::REQUIRED, '(string) friends fb_delegated')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        // HC will be Command Arguments
        $friendFbDelegated = $input->getArgument("friendFbDelegated");
        $friendFbDelegated = 104003390786397;

        // Friend
        $friend = $this->searchFriendByFbDelegatedHandler->handle(new SearchFriendByFbDelegatedCommand($friendFbDelegated));
        $io->writeln("TODO Returns array of Actions");
//        $action = $this->createActionHandler->handle(
//            new CreateActionCommand(
//                $thing,
//                $friend,
//                $input->getArgument("httpVerb"),
//                $input->getArgument("route"),
//                $input->getArgument("actionDescription")
//            )
//        );

//        $io->success('Created Action ['.$action->getHttpVerb().' '.$action->getRoute().'] with description "'.$action->getDescription().'" for ThingId ['.$action->getId().']');
    }
}
