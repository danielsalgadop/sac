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
//            print "route [".$route."] thingId ".$thing->getId().PHP_EOL;
            // avoid saving same route for same thing (this could be done with a Unique in ddbb)



            $actionRepo = $this->em->getRepository(Action::class);

//            /** @var Action $action */
            $action = $actionRepo->findOneBy(['wt' => $thing->getId(), 'route' => $route]);

//            dd($action);
//
//            foreach ($actions as $action) {
//                $storedThing = $action->getWt();
//                if ($storedThing->getId() === $thing->getId() && $action->getRoute() === $route) {
//                    return $action;
//                }
//            }
            if($action){
//                dd("exite");
                return $action;
            }
//            dd("no existe");
//            dd($action);

//            $allActions = $actionRepo->findAll();
//            /** @var Action $storedAction */
//            foreach ($allActions as $storedAction) {
//                $actualThing = $storedAction->getWt();
//                if($actualThing->getId() === $thing->getId() &&
//                    $storedAction->getRoute() === $route
//                ){
//                    return $storedAction;
//                }
//            }


            $action = new Action($thing, $route);
            $this->em->persist($action);
            $this->em->flush();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $action;
    }

}