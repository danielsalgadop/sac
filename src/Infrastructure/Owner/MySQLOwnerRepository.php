<?php

namespace App\Infrastructure\Owner;

use App\Domain\Entity\Owner;
use App\Domain\Repository\OwnerRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
            $this->em->flush();   // TODO: mover el flush al Controller
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function searchOwnerByfbDelegatedOrException(string $fbDelegated)
    {


        // Funciona si busco por id
//        $owner = $this->em->find(Owner::class, 1);

// Intentando usar findOneBuy

        // Intentando obtener repositorio
//        $owner_repo = Controller::get('app.repository.owner');
        // da este error
//        Call to protected method Symfony\Bundle\FrameworkBundle\Controller\Controller::get() from context 'App\Infrastructure\Owner\MySQLOwnerRepository'



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

        if($owner === null){
            throw new \Exception("Non-existing fbDelegated");
        }
        return $owner;
    }
}