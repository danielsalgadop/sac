<?php

namespace App\Infrastructure\Action\Command;

use App\Application\Command\Action\SearchActionByIdCommand;
use App\Application\CommandHandler\Action\SearchActionByIdHandler;
use App\Domain\Entity\Action;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SearchActionById extends Command
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
            ->setDescription('Searches Action by actionId')
            ->addArgument('actionId', InputArgument::REQUIRED, '(int) action id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var Action */
        $action = $this->searchActionByIdHandler->handle(new SearchActionByIdCommand($input->getArgument('actionId')));
        dd($action);
    }
}
