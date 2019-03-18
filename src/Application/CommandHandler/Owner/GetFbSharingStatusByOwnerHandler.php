<?php

namespace App\Application\CommandHandler\Owner;


use App\Application\Command\Owner\GetFbSharingStatusByOwnerCommand;
use App\Domain\Entity\Owner;
use App\Domain\Repository\OwnerRepositoryInterface;

class GetFbSharingStatusByOwnerHandler
{

    public function __construct(OwnerRepositoryInterface $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function handle(GetFbSharingStatusByOwnerCommand $command): array
    {

        $owner = $command->getOwner();
        /*
         * shareStatus structure
         *     [ ThingID =>
         *          [
         *          'ActionId' =>
         *              ['FbDelegated_Friend1']
         *                 ... rest of friends
         *          ]
         *          ... rest of actions
         *      ... rest of things
         * ]
         */
        // build $sharingStatus
        $sharingStatus = [];
        foreach ($owner->getThings()  as $thing){
            $sharingStatus[$thing->getId()] = [];
            foreach ($thing->getActions() as $thingAction){
                foreach ($owner->getFriends() as $friend) {
                    foreach ($friend->getActions() as $friendAction) {
                        if($thingAction->getId() === $friendAction->getId()){
                            $sharingStatus[$thing->getId()][$thingAction->getId()][] = $friend->getFbDelegated();
                        }
                    }
                }
            }
        }


        return $sharingStatus;
    }
}