<?php

namespace App\Domain\Repository\Friend;

use App\Domain\Entity\Friend;


interface FriendRepository
{
    public function save(Friend $friend);

    public function searchByfbDelegated(string $fbDelegated): ?Friend;

    public function searchById(int $id): ?Friend;

    public function searchFriendByIdOrException(int $id): Friend;

    public function searchFriendByfbDelegatedOrException(string $fbDelegated): Friend;

}
