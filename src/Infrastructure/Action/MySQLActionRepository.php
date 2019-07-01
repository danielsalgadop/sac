<?php


namespace App\Infrastructure\Action;

use App\Domain\Entity\Action;
use App\Domain\Entity\Thing;
use App\Domain\Repository\Action\ActionRepository;
use Doctrine\ORM\EntityManagerInterface;
use \Exception;

class MySQLActionRepository implements ActionRepository
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }


    public function save(string $name, Thing $thing)
    {
        try {
//            print "route [".$route."] thingId ".$thing->getId().PHP_EOL;
            // avoid saving same route for same thing (this could be done with a Unique in ddbb)



            $actionRepo = $this->em->getRepository(Action::class);

//            /** @var Action $action */
            $action = $actionRepo->findOneBy(['thing_id' => $thing->getId(), 'name' => $name]);

//            dd($action);
//
//            foreach ($actions as $action) {
//                $storedThing = $action->getThing();
//                if ($storedThing->getId() === $thing->getId() && $action->getName() === $route) {
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
//                $actualThing = $storedAction->getThing();
//                if($actualThing->getId() === $thing->getId() &&
//                    $storedAction->getName() === $route
//                ){
//                    return $storedAction;
//                }
//            }


            $action = new Action($thing, $name);
            $this->em->persist($action);
            $this->em->flush();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $action;
    }

    public function searchByIdOrException(int $id): Action
    {
        $action = $this->em->find(Action::class, $id);

        $exceptionMessage = null;
        if (!$action) {
            $exceptionMessage = "Action not found by";
        }

        if ($action === null) {
            $exceptionMessage = "Non-existing";
        }

        if ($exceptionMessage !== null) {
            throw new \Exception($exceptionMessage." actionId [".$id."]");
        }
        return $action;

    }
}