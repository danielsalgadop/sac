<?php

namespace App\Application\Command\Action;

use App\Domain\Entity\Thing;
use App\Domain\Entity\Friend;

class SearchActionByIdCommand
{
    private $actionId;

    public function __construct(int $actionId)
    {
        $this->actionId = $actionId;
    }

    public function getActionId(): int
    {
        return $this->actionId;
    }
}

