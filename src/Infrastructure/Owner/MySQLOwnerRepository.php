<?php

namespace App\Infrastructure\Owner;

use App\Domain\Entity\Owner;
use App\Domain\Repository\OwnerRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MySQLOwnerRepository implements OwnerRepositoryInterface
{
    private $em;
    private $ownerRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->ownerRepository = $this->em->getRepository(Owner::class);   // Esto es lo que me ha traido quebradero de cabeza
    }

    public function findAll()
    {
        return $this->ownerRepository->findAll();
    }

    public function save(Owner $owner)
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
        $query = $this->em->createQuery('SELECT id FROM App\Domain\Entity\Owner o where o.fb_delegated = ":fbDelegated"')->setParameter('fbDelegated', $fbDelegated);
        // usando QueryBuilder
//        $ownerRepository = $this->em->getRepository(Owner::class);
//        $query = $ownerRepository->createQueryBuilder('o')->select('id')->from(Owner::class, 'o')->where('o.fb_delegated = '.$fbDelegated);
        // comun a CreateQuery (DDL) o QueryBuilder
        $id = $query->getResult();
        return $id;
    }

    public function searchOwnerByfbDelegatedOrException(string $fbDelegated)
    {

        $owner = $this->ownerRepository->findOneBy(['fbDelegated' => $fbDelegated]);
        if (!$owner) {
            throw new \Exception("Owner not found by fbDelegated");
        }


        // Intentando usar este metodo creado en OwnerRepository
        //  return $this->findTOE('fb_delegated_1');


        // Funciona si busco por id
//     $owner = $this->em->find(Owner::class, 1);


        // usar desde Entity Manager el método findOneBy
//        $owner = $this->em->findOneBy(['fbDelegated' => $fbDelegated]);
//         ERROR
//         Attempted to call an undefined method named "findOneBy" of class "Doctrine\ORM\EntityManager".


        // intentando sacar el ID desde el fbDelegated
//            $id = $this->getIdFromfbDelegated($fbDelegated);
//     $owner = $this->em->find(Owner::class, $id);

        // Intentando obtener el Repository, para hacer búsqueda con findOneBy
//    $ownerRepository = $this->em->getRepository(Owner::class);
//        $owner = $ownerRepository->findOneBy(['fb_delegated' => $fbDelegated]);
        // ERROR:
        // The "App\Domain\Entity\Owner" entity has a repositoryClass set to "App\Domain\Repository\OwnerRepository", but this is not a valid class. Check your class naming. If this is meant to be a service id, make sure this service exists and is tagged with "doctrine.repository_service".

        // intentando hacer búsqueda basada en nombre de columna. Esto no funciona porque estoy usando Entinty manager (no el repositorio)
//        $owner = $this->em->findByFbDelegated(1);
//        $owner = $this->em->findByFb_Delegated(1);
//        $owner = $this->em->findByFb_delegated(1);

// Intentando usar findOneBy

        // Intentando obtener repositorio como servicio
//        $owner_repo = Controller::get('app.repository.owner');
        // ERROR
//        Call to protected method Symfony\Bundle\FrameworkBundle\Controller\Controller::get() from context 'App\Infrastructure\Owner\MySQLFriendRepository'


        // intentando usar findeOneBy
//        $owner_repo = $this->em->getRepository('App\Domain\Repository\OwnerRepository');
//        $owner_repo = $this->em->getRepository(Owner::class);
//        $owner_repo = $this->em->getRepository('App\Domain\Repository\OwnerRepository');
//        $owner_repo = $this->em->getRepository(Owner::class);

//        $owner = $owner_repo->findOneBy(['fb_delegated' => $fbDelegated]);
        // da este error:
//        The "App\Domain\Entity\Owner" entity has a repositoryClass set to "App\Domain\Repository\OwnerRepository", but this is not a valid class. Check your class naming. If this is meant to be a service id, make sure this service exists and is tagged with "doctrine.repository_service".


//    Intentando usar querybuilder
//        $qb = new QueryBuilder($this->em);
//        $qb->select('*')->from('owner','o')->where('fb_delegated = "'.$fbDelegated.'"');
//        $owner = $qb->getFirstResult();
//        $toe = $qb->getQuery();

        if ($owner === null) {
            throw new \Exception("Non-existing fbDelegated");
        }
        return $owner;
    }
}