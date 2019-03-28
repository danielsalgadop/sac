<?php

namespace App\Application\CommandHandler\Thing;

use App\Application\Command\Thing\FindByIdCommand;
use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingRepository;

class SearchThingByIdHandler
{
    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function handle(FindByIdCommand $findByIdCommand):Thing
    {
        $thingId = $findByIdCommand->getThingId();

        $thing = $this->thingRepository->findByIdOrException($thingId);
        return $thing;
    }
}
