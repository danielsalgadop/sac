<?php

namespace App\Application\CommandHandler\Friend;

use App\Application\Command\Friend\CreateFriendCommand;
use App\Domain\Entity\Friend;
use App\Domain\Repository\Friend\FriendRepositoryInterface;

class CreateFriendHandler
{
    public function __construct(FriendRepositoryInterface $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    public function handle(CreateFriendCommand $createFriendCommand)
    {
        $fbDelegated = $createFriendCommand->getFbDelegated();

        // create Friend if does not exit
        if(null === $this->friendRepository->searchByfbDelegated($fbDelegated)) {
            $friend = new Friend();
            $friend->setFbDelegated($fbDelegated);
            $this->friendRepository->save($friend);
        }
    }
}
