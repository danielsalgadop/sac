<?php

namespace App\Infrastructure\Friend;

use App\Domain\Entity\Friend;
use App\Domain\Repository\Friend\FriendRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    // TODO: creo que esto no se usa
    public function getIdFromfbDelegated(string $fbDelegated)
    {
//        return 1;
        // usando CreateQuery
        $query = $this->em->createQuery('SELECT id FROM App\Domain\Entity\Friend o where o.fb_delegated = ":fbDelegated"')->setParameter('fbDelegated', $fbDelegated);
        // usando QueryBuilder
//        $friendRepository = $this->em->getRepository(Friend::class);
//        $query = $friendRepository->createQueryBuilder('o')->select('id')->from(Friend::class, 'o')->where('o.fb_delegated = '.$fbDelegated);
        // comun a CreateQuery (DDL) o QueryBuilder
        $id = $query->getResult();
        return $id;
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
        return $friend;

    }
}