<?php

namespace App\Infrastructure\Action\Command;

use App\Application\Command\Action\CreateActionCommand;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Action\CreateActionHandler;
use App\Application\CommandHandler\Friend\SearchFriendByFbDelegatedHandler;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Domain\Entity\Action;
use App\Domain\Entity\Thing;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class Create extends Command
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
            ->setDescription('Creates Action')
            ->addArgument('thingId', InputArgument::REQUIRED, '(int) thing id')
            // this action Name really matches this is action name (links->actions->link->resources)
            ->addArgument('name', InputArgument::REQUIRED, '(string) name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        /* @var $thing Thing */
        $thing = $this->searchThingByIdHandler->handle(new SearchThingByIdCommand($input->getArgument("thingId")));

        /* @var $action Action */
        $action = $this->createActionHandler->handle(
            new CreateActionCommand(
                $thing,
                $input->getArgument("name")
            )
        );

        $io->success('Created Action [' . $action->getId() . '] with name (actionName) [' . $action->getName() . ']for ThingId [' . $thing->getId() . ']');
    }
}
