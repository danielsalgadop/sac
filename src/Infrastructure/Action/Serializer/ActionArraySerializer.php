<?php

namespace App\Infrastructure\Action\Serializer;

use App\Domain\Entity\Action;

class ActionArraySerializer
{
    public static function serialize(Action $action)
    {
        return ['id' => $action->getId(), 'httpVerb' => $action->getHttpVerb(), 'description' => $action->getDescription()];
    }
}