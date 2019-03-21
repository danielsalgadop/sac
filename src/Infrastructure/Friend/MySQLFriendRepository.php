<?php

namespace App\Infrastructure\Friend;

use App\Domain\Entity\Friend;
use App\Domain\Repository\Friend\FriendRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
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

    public function searchFriendByfbDelegatedOrException(string $fbDelegated)
    {

        $owner = $this->friendRepository->findOneBy(['fbDelegated' => $fbDelegated]);
        if (!$owner) {
            throw new \Exception("Friend not found by fbDelegated");
        }



        if ($owner === null) {
            throw new \Exception("Non-existing fbDelegated");
        }
        return $owner;
    }
}