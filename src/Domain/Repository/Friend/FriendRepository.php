<?php

namespace App\Domain\Repository\Friend;

use App\Domain\Entity\Friend;


interface FriendRepository
{
    public function save(Friend $friend);
    public function searchByfbDelegated(string $fbDelegated);
    public function searchById(int $id);

}
