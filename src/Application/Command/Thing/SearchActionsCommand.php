<?php

namespace App\Application\Command\Thing;

use App\Domain\Entity\Thing;

class SearchActionsCommand
{
    private $thing;

    public function __construct(Thing $thing)
    {
        $this->thing = $thing;
    }

    public function getThing()
    {
        return $this->thing;
    }
}

