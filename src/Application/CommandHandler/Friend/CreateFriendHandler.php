<?php

namespace App\Application\CommandHandler\Friend;

use \Exception;
use App\Application\Command\Friend\CreateFriendCommand;
use App\Domain\Entity\Friend;
use App\Domain\Repository\Friend\FriendRepository;

class CreateFriendHandler
{
    public function __construct(FriendRepository $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    public function handle(CreateFriendCommand $createFriendCommand): Friend
    {
        $fbDelegated = $createFriendCommand->getFbDelegated();
        $name = $createFriendCommand->getName();

        try {
            $storedFriend = $this->friendRepository->searchFriendByfbDelegatedOrException($fbDelegated);
        } catch (\Exception $e) {
            $friend = new Friend($fbDelegated, $name);
            $this->friendRepository->save($friend);
            $storedFriend = $friend;
        }

        return $storedFriend;
    }
}
