<?php

namespace App\Application\CommandHandler\Owner;


use App\Application\Command\Owner\GetFbSharingStatusByOwnerCommand;
use App\Domain\Entity\Action;
use App\Domain\Entity\Friend;
use App\Domain\Entity\Owner;
use App\Domain\Repository\OwnerRepository;
use App\Domain\Entity\Thing;

class GetFbSharingStatusByOwnerHandler
{

    public function __construct(OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function handle(GetFbSharingStatusByOwnerCommand $command): array
    {

        $owner = $command->getOwner();
        /*
         *
         *
         * shareStatus structure
         *   1 => array:2 [
         *       "thingId" => 1
         *       "actions" => array:2 [
         *         1 => "103671587486416"   // this key is action id  => fbDelegated
         *         2 => "104003390786397"
         *       ]
         *     ]
         *
         */
        // build $sharingStatus
        $sharingStatus = [];

        $sharingStatus = [];
        /** @var Thing $thing */
        $i = 1;
        foreach ($owner->getThings()  as $thing){

            $sharingStatus[$i]['thingId'] = $thing->getId();

            /** @var Action $thingAction */
            foreach ($thing->getActions() as $thingAction){

                /** @var Friend $friend */
                foreach ($owner->getFriends() as $friend) {

                    foreach ($friend->getActions() as $friendAction) {

                        if($thingAction->getId() === $friendAction->getId()){

                            $sharingStatus[$i]['actions'][$thingAction->getId()][] = $friend->getFbDelegated();
                        }
                    }
                }
            }
            $i++;
        }

//        foreach ($owner->getThings()  as $thing){
//            $sharingStatus[$thing->getId()] = [];
//            foreach ($thing->getActions() as $thingAction){
//                foreach ($owner->getFriends() as $friend) {
//                    foreach ($friend->getActions() as $friendAction) {
//                        if($thingAction->getId() === $friendAction->getId()){
//                            $sharingStatus[$thing->getId()][$thingAction->getId()][] = $friend->getFbDelegated();
//                        }
//                    }
//                }
//            }
//        }


        return $sharingStatus;
    }
}