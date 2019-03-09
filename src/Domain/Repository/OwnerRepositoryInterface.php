<?php


namespace App\Domain\Repository;
use App\Domain\Entity\Owner;


interface OwnerRepositoryInterface
{
    public function save(Owner $owner);
    public function searchOwnerByfbDelegatedOrException(string $fbDelegated);
    public function getIdFromfbDelegated(string $fbDelegated);
    public function findAll();
}
