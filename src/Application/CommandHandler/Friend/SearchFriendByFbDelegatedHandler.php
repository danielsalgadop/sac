<?php

namespace App\Application\CommandHandler\Friend;


use App\Application\Command\Friend\SearchFriendByFbDelegatedCommand;
use App\Domain\Entity\Friend;
use App\Domain\Repository\Friend\FriendRepositoryInterface;

class SearchFriendByFbDelegatedHandler
{

    public function __construct(FriendRepositoryInterface $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }


    public function handle(SearchFriendByFbDelegatedCommand $command): Friend
    {

        $fbDelegated = $command->getFbDelegated();
        $friend = $this->friendRepository->searchFriendByfbDelegatedOrException($fbDelegated);

        //        $user = $friend->getUser();
//        $user->correctCredentialsOrException($command->getUser(),$command->getPassword());
        return $friend;
    }
}