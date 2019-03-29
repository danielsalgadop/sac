<?php

namespace App\Application\CommandHandler\Action;

use App\Application\Command\Action\CreateActionCommand;
use App\Domain\Entity\Action;
use App\Domain\Repository\Action\ActionRepository;

class CreateActionHandler
{
    private $actionRespository;

    public function __construct(ActionRepository $actionRespository)
    {
        $this->actionRespository = $actionRespository;
    }

    public function handle(CreateActionCommand $createActionCommand): Action
    {
        return $this->actionRespository->save(
            $createActionCommand->getHttpVerb(),
            $createActionCommand->getRoute(),
            $createActionCommand->getThing(),
            $createActionCommand->getFriend(),
            $createActionCommand->getActionDescription()
        );
    }
}