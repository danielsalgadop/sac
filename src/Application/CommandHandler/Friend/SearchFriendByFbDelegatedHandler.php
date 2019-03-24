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
        // TODO: ojo hasta que no sea tipo unique en la bbdd puede existir mismo friend.fb_delegated. Esto no debería ser asi
        // si en tabla friend hace referencia a misma persona debería haber solo 1 entrada
        $fbDelegated = $searchFriendByFbDelegatedCommand->getFbDelegated();
        $friend = $this->friendRepository->searchFriendByfbDelegatedOrException($fbDelegated);

        return $friend;
    }
}