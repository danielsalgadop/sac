<?php

namespace App\Infrastructure\Owner\Command;

use App\Application\Command\Owner\GetListThingsByOwnerCommand;
use App\Application\CommandHandler\Owner\GetListThingsByOwnerHandler;
use App\Domain\Repository\OwnerRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;

class GetListThingsByOwner extends Command
{
    protected static $defaultName = 'app:Owner:GetListThingsByOwner';
    private $ownerRepository;

    public function __construct(OwnerRepository $ownerRepository)
    {
        parent::__construct();
        $this->ownerRepository = $ownerRepository;
    }


    protected function configure()
    {
        $this
            ->setDescription('Given an fb_delegated returns list of things')
            ->addArgument('fbDelegated', InputArgument::REQUIRED, '(string) fb_delegated')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fbDelegated = $input->getArgument('fbDelegated');

        $searchOwnerByFbDelegatedCommand = new SearchOwnerByFbDelegatedCommand($fbDelegated);
        $searchOwnerByFbDelegatedHandler = new SearchOwnerByFbDelegatedHandler($this->ownerRepository);

        $owner = $searchOwnerByFbDelegatedHandler->handle($searchOwnerByFbDelegatedCommand);

        $getListThingsByOwnerCommand = new GetListThingsByOwnerCommand($owner);
        $getListThingsByOwnerHandler = new GetListThingsByOwnerHandler();


        $things = $getListThingsByOwnerHandler->handle($getListThingsByOwnerCommand);
        dd($things);
    }
}
