<?php

namespace App\Application\CommandHandler\Action;

use App\Application\Command\Action\CreateActionCommand;
use App\Domain\Entity\Action;
use App\Domain\Repository\Action\ActionRepository;

class CreateActionHandler
{
    /** @var ActionRepository  */
    private $actionRepository;

    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    public function handle(CreateActionCommand $createActionCommand): Action
    {

        return $this->actionRepository->save(
            $createActionCommand->getName(),
            $createActionCommand->getThing()
        );
    }
}