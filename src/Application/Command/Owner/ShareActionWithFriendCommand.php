<?php


namespace App\Application\Command\Owner;


use App\Domain\Entity\Action;
use App\Domain\Entity\Friend;
use App\Domain\Entity\Owner;

class ShareActionWithFriendCommand
{
    private $friend;
    private $action;
    private $owner;

    public function __construct(Owner $owner, Friend $friend, Action $action)
    {
        $this->owner = $owner;
        $this->friend = $friend;
        $this->action = $action;
    }

    public function getFriend(): Friend
    {
        return $this->friend;
    }

    public function getAction(): Action
    {
        return $this->action;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

}