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
        $name = $createOwnerCommand->getName();
        $fb_delegated = $createOwnerCommand->getFbDelegated();
        // TODO: avoid creating owner if fb_delegated already exists
        $owner = new Owner($name, $fb_delegated);
        $this->ownerRepository->save($owner);
        return $owner;

    }
}
