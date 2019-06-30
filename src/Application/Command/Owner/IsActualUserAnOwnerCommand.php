<?php


namespace App\Application\Command\Owner;


class IsActualUserAnOwnerCommand
{
    private $actualFbDelegated;

    public function __construct(int $actualFbDelegated)
    {
        $this->actualFbDelegated = $actualFbDelegated;
    }


    public function getActualFbDelegated(): int
    {
        return $this->actualFbDelegated;
    }
}