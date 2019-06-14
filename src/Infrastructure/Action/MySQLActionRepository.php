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
            $actionRepo = $this->em->getRepository(Action::class);
//            $foo = $actionRepo->findBy(['id' => $thing->getId(), 'route' => $route]);
//            dd($foo);
//            $action = $actionRepo->find($thing->getId());
            $allActions = $actionRepo->findAll();
//            if($action){
//                return $action;
//            }

            /** @var Action $storedAction */
            foreach ($allActions as $storedAction) {
                $actualThing = $storedAction->getWt();
                if($actualThing->getId() === $thing->getId() &&
                    $storedAction->getRoute() === $route
                ){
                    return $storedAction;
                }
            }
//            if($foo){
//                dd("exists");
//            }
//            dd("does not exist");


            $action = new Action($thing, $route);
            $this->em->persist($action);
            $this->em->flush();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $action;
    }

}