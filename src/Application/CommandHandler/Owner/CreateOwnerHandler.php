<?php

namespace App\Application\CommandHandler\Owner;

use App\Application\Command\Owner\CreateOwnerCommand;
use App\Domain\Entity\Owner;
use App\Domain\Repository\OwnerRepository;

class CreateOwnerHandler
{
    public function __construct(OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function handle(CreateOwnerCommand $createOwnerCommand)
    {
        $name = $createOwnerCommand->getName();
        $fb_delegated = $createOwnerCommand->getFbDelegated();
        $owner = new Owner($name, $fb_delegated);
        $this->ownerRepository->save($owner);

    }
}
