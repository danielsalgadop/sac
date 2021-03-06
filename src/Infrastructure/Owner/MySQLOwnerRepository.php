<?php

namespace App\Infrastructure\Owner;

use App\Domain\Entity\Owner;
use App\Domain\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class MySQLOwnerRepository implements OwnerRepository
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function find(int $id)
    {
        /** @var Owner $owner */
        $owner = $this->em->find(Owner::class, $id);
        return $owner;
    }

    public function save(Owner $owner)
    {
        try {
            $this->em->persist($owner);
            $this->em->flush();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $owner->getId();
    }

    public function searchOwnerByfbDelegatedOrException(string $fbDelegated): Owner
    {
        /** @var Owner $owner */
        $owner = $this->em
            ->getRepository(Owner::class)
            ->findOneBy(['fbDelegated' => $fbDelegated]);

        if ($owner === null) {
            throw new Exception("Non-existing fbDelegated");
        }
        return $owner;
    }
}