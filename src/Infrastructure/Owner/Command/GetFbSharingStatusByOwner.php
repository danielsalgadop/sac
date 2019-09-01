<?php

namespace App\Infrastructure\Owner\Command;


use App\Application\Command\Owner\GetFbSharingStatusByOwnerCommand;
use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\GetFbSharingStatusByOwnerHandler;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class GetFbSharingStatusByOwner extends Command
{
    protected static $defaultName = "app:Owner:GetFbSharingStatus";
    private $getFbSharingStatusByOwnerHandler;
    private $searchOwnerByFbDelegatedHandler;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler, GetFbSharingStatusByOwnerHandler $getFbSharingStatusByOwnerHandler)
    {
        parent::__construct();
        $this->getFbSharingStatusByOwnerHandler = $getFbSharingStatusByOwnerHandler;
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
    }

    protected function configure()
    {
        $this
            ->setDescription("gets All relationships between Owner-Friends-Actions")
            ->addArgument('OwnerFbDelegated', InputArgument::REQUIRED, 'fb_delegated of Owner (must exist)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($input->getArgument("OwnerFbDelegated")));

        $fbSharingStatus = $this->getFbSharingStatusByOwnerHandler->handle(new GetFbSharingStatusByOwnerCommand($owner));

        dd($fbSharingStatus);

    }
}