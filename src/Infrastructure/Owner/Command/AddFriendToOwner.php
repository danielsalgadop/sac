<?php

namespace App\Infrastructure\Owner\Command;

use App\Domain\Repository\Friend\FriendRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Domain\Repository\OwnerRepository;

use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use App\Application\Command\Friend\SearchFriendByFbDelegatedCommand;
use App\Application\CommandHandler\Friend\SearchFriendByFbDelegatedHandler;

class AddFriendToOwner extends Command
{
    protected static $defaultName = 'app:Owner:AddFriendToOwner';
    private $ownerRepository;
    private $friendRepository;

    public function __construct(OwnerRepository $ownerRepository, FriendRepository $friendRepository)
    {
        parent::__construct();
        $this->ownerRepository = $ownerRepository;
        $this->friendRepository = $friendRepository;
    }


    protected function configure()
    {
        $this
            ->setDescription('Given fbDelegated of Owner and fbDelegated of Friend will create a relationshing in owner_friend table')
            ->addArgument('OwnerFbDelegated', InputArgument::REQUIRED, 'fb_delegated of Owner (must exist)')
            ->addArgument('FriendFbDelegated', InputArgument::REQUIRED, 'fb_delegated of Friend (must exist)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $ownerFbDelegated = $input->getArgument('OwnerFbDelegated');
        $friendFbDelegated = $input->getArgument('FriendFbDelegated');

        $searchOwnerByFbDelegatedCommand = new SearchOwnerByFbDelegatedCommand($ownerFbDelegated);
        $searchOwnerByFbDelegatedHandler = new SearchOwnerByFbDelegatedHandler($this->ownerRepository);
        $owner = $searchOwnerByFbDelegatedHandler->handle($searchOwnerByFbDelegatedCommand);

        $searchFriendByFbDelegatedCommand = new SearchFriendByFbDelegatedCommand($friendFbDelegated);
        $searchFriendByFbDelegatedHandler = new SearchFriendByFbDelegatedHandler($this->friendRepository);
        $friend = $searchFriendByFbDelegatedHandler->handle($searchFriendByFbDelegatedCommand);


        $owner->addFriend($friend);
        $this->ownerRepository->save($owner);
        // TODO: ct if owner has already friend


        $io->success('');
    }
}
