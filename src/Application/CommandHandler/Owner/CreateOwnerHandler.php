<?php

namespace App\Application\CommandHandler\Owner;

use App\Application\Command\Owner\CreateOwnerCommand;
use App\Domain\Entity\Owner;
use App\Domain\Repository\OwnerRepository;

class CreateOwnerHandler
{
    private $ownerRepository;

    public function __construct(OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function handle(CreateOwnerCommand $createOwnerCommand)
    {
        // TODO: avoid creating owner if fb_delegated already exists
        $owner = new Owner($createOwnerCommand->getName(), $createOwnerCommand->getFbDelegated());
        $this->ownerRepository->save($owner);
        return $owner;

    }
}
