<?php

namespace App\Infrastructure\Action\Command;

use App\Application\Command\Action\CreateActionCommand;
use App\Application\Command\Action\SearchActionByIdCommand;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Action\SearchActionByIdHandler;

class SearchActionById extends ContainerAwareCommand
{
    protected static $defaultName = 'app:Action:SearchActionById';
    private $searchActionByIdHandler;

    public function __construct(SearchActionByIdHandler $searchActionByIdHandler)
    {
        parent::__construct();
        $this->searchActionByIdHandler = $searchActionByIdHandler;
    }

    protected function configure()
    {
        $this
            ->setDescription('Searches an action By Action id')
            ->addArgument('actionId', InputArgument::REQUIRED, '(int) action id')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $action = $this->searchActionByIdHandler->handle(new SearchActionByIdCommand($input->getArgument('actionId')));
        dd($action);
    }
}
