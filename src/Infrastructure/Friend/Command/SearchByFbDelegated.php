<?php

namespace App\Infrastructure\Friend\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Application\Command\Friend\SearchFriendByFbDelegatedCommand;
use App\Application\CommandHandler\Friend\SearchFriendByFbDelegatedHandler;

class SearchByFbDelegated extends ContainerAwareCommand
{
    protected static $defaultName = 'app:Friend:FindByFbDelegated';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('fbDelegated', InputArgument::REQUIRED, '(string) fb_delegated (must exist)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fbDelegated = $input->getArgument('fbDelegated');

        $friendRepository = $this->getContainer()->get('app.repository.friend');
        $searchFriendByFbDelegatedCommand = new SearchFriendByFbDelegatedCommand($fbDelegated);
        $searchFriendByFbDelegatedHandler = new SearchFriendByFbDelegatedHandler($friendRepository);
        $friend = $searchFriendByFbDelegatedHandler->handle($searchFriendByFbDelegatedCommand);

        dd($friend);
    }
}
