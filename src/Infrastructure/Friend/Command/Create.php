<?php

namespace App\Infrastructure\Friend\Command;


use App\Domain\Entity\Friend;
use App\Domain\Repository\Friend\FriendRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Application\Command\Friend\CreateFriendCommand;
use App\Application\CommandHandler\Friend\CreateFriendHandler;



class Create extends Command
{
    protected static $defaultName = "app:Friend:Create";
    private $friendRepository;

    public function __construct(FriendRepository $friendRepository)
    {
        parent::__construct();
        $this->friendRepository = $friendRepository;
    }

    protected function configure()
    {
        $this->setDescription("Test");
        $this
            ->addArgument('fbDelegated', InputArgument::REQUIRED, 'fb_delegated of Friend')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $createFriendHandler = new CreateFriendHandler($this->friendRepository);
        $createFriendCommand = new CreateFriendCommand($input->getArgument('fbDelegated'));
        $createFriendHandler->handle($createFriendCommand);
    }
}