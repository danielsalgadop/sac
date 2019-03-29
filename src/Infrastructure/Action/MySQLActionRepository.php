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


    public function save(string $httpVerb, string $route, Thing $thing, Friend $friend, string $actionDescription)
    {
        try {
            $action = new Action();
            $action->setDescription($actionDescription);
            $action->setHttpVerb($httpVerb);
            $action->setRoute($route);
            $action->setWt($thing);
            $action->addFriend($friend);
            $this->em->persist($action);
            $this->em->flush(); // TODO: mover el flush al Controller
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $action;
    }

}