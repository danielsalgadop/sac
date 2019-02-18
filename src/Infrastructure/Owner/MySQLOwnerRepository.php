<?php

namespace App\Infrastructure\Owner;

use App\Domain\Entity\Owner;
use App\Domain\Repository\OwnerRepository;
use Doctrine\ORM\EntityManager;

class MySQLOwnerRepository implements OwnerRepository
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function save(Owner $owner)
    {
        try {
            $this->em->persist($owner);
            $this->em->flush();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function searchOwnerByfbDelegatedOrException(string $fbDelegated)
    {

        $owner = $this->em->findByFbDelegated(Owner::class, $fbDelegated);
        if($owner === null){
            throw new \Exception("Non-existing fbDelegated");
        }
        return $owner;
    }
}