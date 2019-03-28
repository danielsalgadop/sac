<?php


namespace App\Application\CommandHandler\Owner;


use App\Application\Command\Owner\AddFriendToOwnerCommand;
use App\Domain\Repository\OwnerRepository;

class AddFriendToOwnerHandler
{
    private $ownerRepository;
    public function __construct(OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function handle(AddFriendToOwnerCommand $addFriendToOwnerCommand)
    {
        $friend = $addFriendToOwnerCommand->getFriend();
        $owner = $addFriendToOwnerCommand->getOwner();
        $owner->addFriend($friend);
        $this->ownerRepository->save($owner);
        return $owner;
    }
}
