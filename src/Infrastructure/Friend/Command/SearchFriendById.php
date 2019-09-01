<?php

namespace App\Infrastructure\Friend\Command;

use App\Application\Command\Friend\SearchFriendByIdCommand;
use App\Application\CommandHandler\Friend\SearchFriendByIdHandler;
use App\Domain\Entity\Friend;
use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchFriendById extends Command
{
    protected static $defaultName = 'app:Friend:SearchFriendById';
    private $searchFriendByIdHandler;

    public function __construct(SearchFriendByIdHandler $searchFriendByIdHandler)
    {
        parent::__construct();
        $this->searchFriendByIdHandler = $searchFriendByIdHandler;
    }

    protected function configure()
    {
        $this
            ->setDescription('given id returns friend')
            ->addArgument('id', InputArgument::REQUIRED, '(int) id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');

        $searchFriendByIdHandler = $this->searchFriendByIdHandler;
        /** @var $friend Friend */
        $friend = $searchFriendByIdHandler->handle(new SearchFriendByIdCommand($id));

        dd($friend);
    }
}
