<?php

namespace App\Application\CommandHandler\Friend;


use App\Application\Command\Friend\SearchFriendByFbDelegatedCommand;
use App\Domain\Entity\Friend;
use App\Domain\Repository\Friend\FriendRepository;

class SearchFriendByFbDelegatedHandler
{

    public function __construct(FriendRepository $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }


    public function handle(SearchFriendByFbDelegatedCommand $command): Friend
    {

        $fbDelegated = $command->getFbDelegated();
        $friend = $this->friendRepository->searchFriendByfbDelegatedOrException($fbDelegated);

        return $friend;
    }
}