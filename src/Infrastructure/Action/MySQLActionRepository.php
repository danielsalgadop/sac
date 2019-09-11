<?php


namespace App\Infrastructure\Action;

use App\Domain\Entity\Action;
use App\Domain\Entity\Thing;
use App\Domain\Repository\Action\ActionRepository;
use Doctrine\ORM\EntityManagerInterface;

class MySQLActionRepository implements ActionRepository
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }


    public function save(string $name, Thing $thing): Action
    {
        $actionRepo = $this->em->getRepository(Action::class);

        /** @var Action $action */
        $action = $actionRepo->findOneBy(['thing' => $thing->getId(), 'name' => $name]);
        if ($action) {
            return $action;
        }
        $action = new Action($thing, $name);
        $this->em->persist($action);
        $this->em->flush();
        return $action;
    }

    public function searchByIdOrException(int $id): Action
    {
        $action = $this->em->find(Action::class, $id);

        if ($action === null) {
            throw new \Exception("Non-existing actionId [" . $id . "]");
        }
        return $action;

    }
}