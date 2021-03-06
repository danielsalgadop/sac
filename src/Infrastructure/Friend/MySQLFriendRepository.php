<?php

namespace App\Infrastructure\Friend;

use App\Domain\Entity\Friend;
use App\Domain\Repository\Friend\FriendRepository;
use Doctrine\ORM\EntityManagerInterface;

class MySQLFriendRepository implements FriendRepository
{
    private $em;
    private $friendRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->friendRepository = $this->em->getRepository(Friend::class);   // Esto es lo que me ha traido quebradero de cabeza
    }

    public function findAll()
    {
        return $this->friendRepository->findAll();
    }

    public function searchByfbDelegated(string $fbDelegated): ?Friend
    {
        return $this->friendRepository->findOneBy(['fbDelegated' => $fbDelegated]);
    }

    public function searchById(int $id): ?Friend
    {
        return $this->friendRepository->findOneBy(['id' => $id]);
    }

    public function save(Friend $friend)
    {
        try {
            $this->em->persist($friend);
            $this->em->flush();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $friend;
    }

    public function searchFriendByIdOrException(int $id): Friend
    {
        $friend = $this->searchById($id);
        if ($friend === null) {
            throw new \Exception("Non-existing Friend id [" . $id . "]");
        }
        return $friend;
    }


    public function searchFriendByfbDelegatedOrException(string $fbDelegated): Friend
    {
        $friend = $this->friendRepository->findOneBy(['fbDelegated' => $fbDelegated]);
        if ($friend === null) {
            throw new \Exception("Non-existing fbDelegated [" . $fbDelegated . "]");
        }
        return $friend;
    }
}