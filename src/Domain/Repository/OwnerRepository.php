<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Owner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Owner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Owner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Owner[]    findAll()
 * @method Owner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Owner::class);
    }


    public function findTOE($fbDelegated)
    {

//        return $this->find(1);
        return $this->findOneBy(['fbDelegated' => $fbDelegated]);
    }

    // /**
    //  * @return Sac[] Returns an array of Sac objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sac
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
