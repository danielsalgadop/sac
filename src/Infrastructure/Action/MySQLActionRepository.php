<?php


namespace App\Infrastructure\Action;

use App\Domain\Entity\Action;
use App\Domain\Entity\Thing;
use App\Domain\Entity\Friend;
use App\Domain\Repository\Action\ActionRepository;
use Doctrine\ORM\EntityManagerInterface;

class MySQLActionRepository implements ActionRepository
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }


    public function save(string $route, Thing $thing)
    {
        try {
            // avoid saving same route for same thing (this could be done with a Unique in ddbb)
            $actionRepo = $this->em->getRepository(Action::class);
            $action = $actionRepo->findBy(['id' => $thing->getId(), 'route' => $route]);
            if($action){
                return $action;
            }

            $action = new Action($thing, $route);
            $this->em->persist($action);
            $this->em->flush();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $action;
    }

}