<?php

namespace App\Infrastructure\Friend\Command;


use App\Domain\Entity\Friend;
use App\Domain\Repository\Friend\FriendRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\Command\Friend\AddFriendCommand;
use App\Application\CommandHandler\Friend\AddFriendHandler;



class Create extends Command
{
    protected static $defaultName = "app:addFriend";
    private $friendRepository;

    public function __construct(FriendRepositoryInterface $friendRepository)
    {
        parent::__construct();
        $this->friendRepository = $friendRepository;
    }

    protected function configure()
    {
        $this->setDescription("Test");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $friend = $this->friendRepository->searchFriendByfbDelegatedOrException('fb_delegated_1');
        $addFriendHandler = new AddFriendHandler($this->friendRepository);
        $addFriendCommand = new AddFriendCommand();
        $friend = new Friend();
        $friend->setFbDelegated('fb_friend_delegated1');

        $this->friendRepository->persist($friend);
        $this->friendRepository->flush();
//        $friend->addFriend($friend);
        $friend->manager->flush();

//        dump($all);
//        $all =
//        print "asdf";
    }
}