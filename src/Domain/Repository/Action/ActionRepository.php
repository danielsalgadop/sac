<?php


namespace App\Domain\Repository\Action;

use App\Domain\Entity\Action;
use App\Domain\Entity\Thing;

interface ActionRepository
{
    public function save(string $route, Thing $thing): Action;
    public function searchByIdOrException(int $id);  // actually not in use, created just-in-case
}
