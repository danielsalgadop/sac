<?php

namespace App\Infrastructure\Friend\Command;

use App\Application\Command\Friend\SearchFriendByIdCommand;
use App\Application\CommandHandler\Friend\SearchFriendByIdHandler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchByFbId extends ContainerAwareCommand
{
    protected static $defaultName = 'app:Friend:SearchFriendById';

    protected function configure()
    {
        $this
            ->setDescription('given id returns friend')
            ->addArgument('id', InputArgument::REQUIRED, '(int) id')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');

        $friendRepository = $this->getContainer()->get('app.repository.friend');
        $searchFriendByIdHandler = new SearchFriendByIdHandler($friendRepository);
        $friend = $searchFriendByIdHandler->handle(new SearchFriendByIdCommand($id));

        dd($friend);
    }
}
