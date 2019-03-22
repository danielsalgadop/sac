<?php

namespace App\Infrastructure\Owner\Command;


use App\Domain\Repository\OwnerRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


use App\Application\Command\Owner\GetFbSharingStatusByOwnerCommand;
use App\Application\CommandHandler\Owner\GetFbSharingStatusByOwnerHandler;

class GetFbSharingStatusByOwner extends Command
{
    protected static $defaultName = "app:Owner:GetFbSharingStatus";
    private $ownerRepository;

    public function __construct(OwnerRepository $ownerRepository)
    {
        parent::__construct();
        $this->ownerRepository = $ownerRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription("gets All relationships between Owner-Friends-Actions")
            ->addArgument('OwnerFbDelegated', InputArgument::REQUIRED, 'fb_delegated of Owner (must exist)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ownerFbDelegated = $input->getArgument("OwnerFbDelegated");
        // TODO: existe un command-handler para esto, no?
        $owner = $this->ownerRepository->searchOwnerByfbDelegatedOrException($ownerFbDelegated);

        $getFbSharingStatusByOwnerCommand = new GetFbSharingStatusByOwnerCommand($owner);
        $getFbSharingStatusByOwnerHandler = new GetFbSharingStatusByOwnerHandler($this->ownerRepository);

        $fbSharingStatus = $getFbSharingStatusByOwnerHandler->handle($getFbSharingStatusByOwnerCommand);

        dd($fbSharingStatus);

    }
}