<?php

namespace App\Infrastructure\Owner\Command;


use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class SearchOwnerByfbDelegated extends Command
{
    protected static $defaultName = "app:Owner:SearchByfbDelegated";

    private $searchOwnerByFbDelegatedHandler;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler)
    {
        parent::__construct();
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
    }


    protected function configure()
    {
        $this
            ->setDescription("Given a fbDelegated gets Owner")
            ->addArgument('OwnerFbDelegated', InputArgument::REQUIRED, 'fb_delegated of Owner (must exist)');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        dump($this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($input->getArgument("OwnerFbDelegated"))));
    }
}