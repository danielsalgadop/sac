<?php

namespace App\Application\CommandHandler\Thing;


use App\Domain\Entity\Owner;
use App\Application\Command\Thing\SearchActionsCommand;


class SearchActionsHandler
{

//    public function __construct(OwnerRepositoryInterface $ownerRepository)
//    {
//        $this->ownerRepository = $ownerRepository;
//    }


    public function handle(SearchActionsCommand $earchActionsCommand): Owner
    {

        $thing = $earchActionsCommand->getThing();
        return $thing->getActions();
    }
}