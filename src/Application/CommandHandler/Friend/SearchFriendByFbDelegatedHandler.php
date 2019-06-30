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


    public function handle(SearchFriendByFbDelegatedCommand $searchFriendByFbDelegatedCommand): Friend
    {
        /** @var Friend $friend */
        $friend = $this->friendRepository->searchFriendByfbDelegatedOrException($searchFriendByFbDelegatedCommand->getFbDelegated());

        return $friend;
    }
}