<?php

namespace App\Application\CommandHandler\Friend;


use App\Application\Command\Friend\SearchFriendByIdCommand;
use App\Domain\Entity\Friend;
use App\Domain\Repository\Friend\FriendRepository;

class SearchFriendByIdHandler
{

    public function __construct(FriendRepository $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    public function handle(SearchFriendByIdCommand $searchFriendByIdCommand): Friend
    {
        return $this->friendRepository->searchFriendByIdOrException($searchFriendByIdCommand->getId());
    }
}