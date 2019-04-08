<?php

namespace App\Infrastructure\Thing;

use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Route;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MySQLThingRepository implements ThingRepository
{
    private $em;
    private $thingRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        // TODO: !!! esto sigue aqui, hay que quitarlo
        $this->thingRepository = $this->em->getRepository(Thing::class);   // Esto es lo que me ha traido quebradero de cabeza
    }

    public function save(Thing $thing)
    {
        try {
            $this->em->persist($thing);
            $this->em->flush();   // TODO: mover el flush al Controller
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function find(int $thingId)
    {
        return $this->thingRepository->find($thingId);
    }

    public function searchThingByIdOrException(int $thingId): Thing
    {
        $thing = $this->find($thingId);
        if($thing === null){
            throw new \Exception("Unknown thing id [".$thingId."]");
        }
        return $thing;
    }
}