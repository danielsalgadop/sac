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
        $friend = new Friend();
        $friend->setFbDelegated($fbDelegated);
        return $this->friendRepository->save($friend);
    }
}
