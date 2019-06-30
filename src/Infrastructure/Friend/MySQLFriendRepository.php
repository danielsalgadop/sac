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

    public function searchByfbDelegated(string $fbDelegated)
    {
        return $this->friendRepository->findOneBy(['fbDelegated' =>$fbDelegated]);
    }

    public function searchById(int $id)
    {
        return $this->friendRepository->findOneBy(['id' =>$id]);
    }

    public function save(Friend $owner)
    {
        try {
            $this->em->persist($owner);
            $this->em->flush();   // TODO: mover el flush al Controller
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function searchFriendByIdOrException(int $id)
    {
        $friend = $this->searchById($id);

        $exceptionMessage = null;
        if (!$friend)  {
            $exceptionMessage = "Friend not found by";
        }
        elseif ($friend === null){
            $exceptionMessage = "Non-existing Friend";
        }

        if($exceptionMessage !== null){
            throw new \Exception($exceptionMessage." id [".$id."]");
        }
        return $friend;
    }

    public function searchFriendByfbDelegatedOrException(string $fbDelegated)
    {
        $friend = $this->friendRepository->findOneBy(['fbDelegated' => $fbDelegated]);

        $exceptionMessage = null;
        if (!$friend) {
            $exceptionMessage = "Friend not found by";
        }

        if ($friend === null) {
            $exceptionMessage = "Non-existing";
        }

        if ($exceptionMessage !== null) {
            throw new \Exception($exceptionMessage." fbDelegated [".$fbDelegated."]");
        }
        dd($friend);
        return $friend;

    }
}