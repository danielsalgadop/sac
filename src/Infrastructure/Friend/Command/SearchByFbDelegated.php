<?php

namespace App\Infrastructure\Friend\Command;

use App\Domain\Entity\Friend;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Application\Command\Friend\SearchFriendByFbDelegatedCommand;
use App\Application\CommandHandler\Friend\SearchFriendByFbDelegatedHandler;

class SearchByFbDelegated extends Command
{
    protected static $defaultName = 'app:Friend:SearchFriendByFbDelegated';
    private $byFbDelegatedHandler;
    private $searchFriendByFbDelegatedHandler;


    public function __construct(SearchFriendByFbDelegatedHandler $searchFriendByFbDelegatedHandler)
    {
        parent::__construct();
        $this->searchFriendByFbDelegatedHandler = $searchFriendByFbDelegatedHandler;
    }

    protected function configure()
    {
        $this
            ->setDescription('given fbDelegated returns friend')
            ->addArgument('fbDelegated', InputArgument::REQUIRED, '(string) friends fb_delegated (must exist)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fbDelegated = $input->getArgument('fbDelegated');

        $searchFriendByFbDelegatedCommand = new SearchFriendByFbDelegatedCommand($fbDelegated);
        /** @var $friend Friend */
        $friend = $this->searchFriendByFbDelegatedHandler->handle($searchFriendByFbDelegatedCommand);

        dd($friend);
    }
}
