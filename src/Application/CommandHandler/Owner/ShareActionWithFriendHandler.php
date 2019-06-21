<?php

namespace App\Application\CommandHandler\Owner;

use App\Application\Command\Owner\ShareActionWithFriendCommand;
use App\Domain\Entity\Action;
use App\Domain\Entity\Friend;
use App\Domain\Entity\Owner;
use App\Domain\Repository\Friend\FriendRepository;
use App\Repository\OwnerRepository;

class ShareActionWithFriendHandler
{

    private $friendRepository;

    public function __construct(FriendRepository $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    public function handle(ShareActionWithFriendCommand $shareActionWithFriendCommand)
    {
        /** @var Friend $friend */
        $friend =  $shareActionWithFriendCommand->getFriend();
        /** @var Action $action */
        $action = $shareActionWithFriendCommand->getAction();

        $friend->addAction($action);
        $this->friendRepository->save($friend);
    }
}