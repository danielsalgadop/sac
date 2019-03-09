<?php


namespace App\Domain\Repository\Friend;
use App\Domain\Entity\Friend;


interface FriendRepositoryInterface
{
    public function save(Friend $friend);
}
