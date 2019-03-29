<?php

namespace App\Application\Command\Action;

use App\Domain\Entity\Thing;
use App\Domain\Entity\Friend;

class CreateActionCommand
{
    private $thing;
    private $friend;
    private $httpVerb;
    private $route;
    private $actionDescription;

    public function __construct(Thing $thing, Friend $friend, string $httpVerb, string $route, string $actionDescription)
    {
        $this->thing = $thing;
        $this->friend = $friend;
        $this->httpVerb = $httpVerb;
        $this->route = $route;
        $this->actionDescription = $actionDescription;
    }

    public function getHttpVerb(): string
    {
        return $this->httpVerb;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getActionDescription(): string
    {
        return $this->actionDescription;
    }

    public function getThing():Thing
    {
        return $this->thing;
    }

    public function getFriend():Friend
    {
        return $this->friend;
    }
}

