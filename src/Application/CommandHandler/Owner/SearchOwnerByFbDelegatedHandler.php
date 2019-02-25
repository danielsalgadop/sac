<?php

namespace App\Application\CommandHandler\Owner;


use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Domain\Entity\Owner;
use App\Domain\Repository\OwnerRepositoryInterface;

class SearchOwnerByFbDelegatedHandler
{

    public function __construct(OwnerRepositoryInterface $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }


    public function handle(SearchOwnerByFbDelegatedCommand $command): Owner
    {

        $fbDelegated = $command->getFbDelegated();

        $owner = $this->ownerRepository->searchOwnerByfbDelegatedOrException($fbDelegated);

        //        $user = $owner->getUser();
//        $user->correctCredentialsOrException($command->getUser(),$command->getPassword());
        return $owner;
    }
}