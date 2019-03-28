<?php

namespace App\Application\CommandHandler\Owner;


use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Domain\Entity\Owner;
use App\Domain\Repository\OwnerRepository;

class SearchOwnerByFbDelegatedHandler
{

    private $ownerRepository;

    public function __construct(OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function handle(SearchOwnerByFbDelegatedCommand $searchOwnerByFbDelegatedCommand): Owner
    {
        return $this->ownerRepository->searchOwnerByfbDelegatedOrException($searchOwnerByFbDelegatedCommand->getFbDelegated());
    }
}