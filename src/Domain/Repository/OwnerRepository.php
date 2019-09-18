<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Owner;


interface OwnerRepository
{
    public function save(Owner $owner);

    public function searchOwnerByfbDelegatedOrException(string $fbDelegated): Owner;

    public function find(int $ownerId);
}
