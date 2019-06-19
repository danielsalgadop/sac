<?php


use App\Application\Command\Friend\ShareActionWithFriendCommand;
use App\Domain\Entity\Owner;
use App\Repository\OwnerRepository;

class ShareActionWithFriendHandler
{

    public function __construct(OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function handle(ShareActionWithFriendCommand $shareActionWithFriendCommand): Owner
    {
        $friend =  $shareActionWithFriendCommand->getFriend();
        $action = $shareActionWithFriendCommand->getAction();
        $owner = $shareActionWithFriendCommand->getOwner();

//        return $this->ownerRepository->searchFriendByIdOrException($shareActionWithFriendCommand->Friend());
        return Owner;
    }
}