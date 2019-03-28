<?php

namespace App\Application\Command\Owner;

use App\Domain\Entity\Friend;
use App\Domain\Entity\Owner;

class AddFriendToOwnerCommand
{
    private $friend;
    private $owner;

    public function __construct(Friend $friend, Owner $owner)
    {
        $this->friend = $friend;
        $this->owner = $owner;
    }

    /**
     * @return Owner
     */
    public function getOwner(): Owner
    {
        return $this->owner;
    }

    /**
     * @return Friend
     */
    public function getFriend(): Friend
    {
        return $this->friend;
    }
}

