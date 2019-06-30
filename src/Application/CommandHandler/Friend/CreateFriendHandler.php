<?php

namespace App\Application\CommandHandler\Friend;

use App\Application\Command\Friend\CreateFriendCommand;
use App\Domain\Entity\Friend;
use App\Domain\Repository\Friend\FriendRepository;

class CreateFriendHandler
{
    public function __construct(FriendRepository $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    public function handle(CreateFriendCommand $createFriendCommand)
    {
        $fbDelegated = $createFriendCommand->getFbDelegated();
        $name = $createFriendCommand->getName();

        $storedFriend = $this->friendRepository->searchByfbDelegated($fbDelegated);
        // create Friend if does not exit
        if(null === $storedFriend) {
            $friend = new Friend($fbDelegated,$name);
            $this->friendRepository->save($friend);
            $storedFriend = $friend;
        }
        return $storedFriend;
    }
}
