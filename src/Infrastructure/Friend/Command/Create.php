<?php

use App\Domain\Entity\Friend;

namespace App\Infrastructure\Friend\Command;


use App\Domain\Entity\Friend;
use App\Domain\Repository\Friend\FriendRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Application\Command\Friend\CreateFriendCommand;
use App\Application\CommandHandler\Friend\CreateFriendHandler;


class Create extends Command
{
    protected static $defaultName = "app:Friend:Create";
    private $friendRepository;
    private $createFriendHandler;

    public function __construct(CreateFriendHandler $createFriendHandler)
    {
        parent::__construct();
        $this->createFriendHandler = $createFriendHandler;
    }

    protected function configure()
    {
        $this->setDescription("Creates a Friend");
        $this
            ->addArgument('fbDelegated', InputArgument::REQUIRED, 'fb_delegated of Friend')
            ->addArgument('friendName', InputArgument::REQUIRED, 'name of Friend');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $createFriendHandler = $this->createFriendHandler;
        $createFriendCommand = new CreateFriendCommand($input->getArgument('fbDelegated'), $input->getArgument('friendName'));
        /* @var Friend */
        $friend = $createFriendHandler->handle($createFriendCommand);
        $io->success('Created Friend [' . $friend->getId() . '] with name (friendName) [' . $friend->getName() . ']');
    }
}