<?php

namespace App\Application\CommandHandler\Action;

use App\Application\Command\Action\CreateActionCommand;
use App\Domain\Entity\Action;
use App\Domain\Repository\Action\ActionRepository;

class CreateActionHandler
{
    /** @var ActionRepository  */
    private $actionRespository;

    public function __construct(ActionRepository $actionRespository)
    {
        $this->actionRespository = $actionRespository;
    }

    public function handle(CreateActionCommand $createActionCommand): Action
    {
        return $this->actionRespository->save(
            $createActionCommand->getRoute(),
            $createActionCommand->getThing()
        );
    }
}