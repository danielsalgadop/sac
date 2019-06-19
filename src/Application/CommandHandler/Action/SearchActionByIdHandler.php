<?php

namespace App\Application\CommandHandler\Action;

use App\Application\Command\Action\CreateActionCommand;
use App\Domain\Entity\Action;
use App\Domain\Repository\Action\ActionRepository;
use App\Application\Command\Action\SearchActionByIdCommand;

class SearchActionByIdHandler
{
    /** @var ActionRepository  */
    private $actionRepository;

    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    public function handle(SearchActionByIdCommand $searchActionByIdCommand): Action
    {
        return $this->actionRepository->searchByIdOrException($searchActionByIdCommand->getActionId());

    }
}