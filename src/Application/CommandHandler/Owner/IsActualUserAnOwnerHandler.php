<?php


namespace App\Application\CommandHandler\Owner;

use App\Application\Command\Owner\IsActualUserAnOwnerCommand;
use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Domain\Entity\Owner;
use App\Infrastructure\Owner\MySQLOwnerRepository;
use \Exception;

class IsActualUserAnOwnerHandler
{
    private $mySQLOwnerRepository;

    public function __construct(MySQLOwnerRepository $mySQLOwnerRepository)
    {
        $this->mySQLOwnerRepository = $mySQLOwnerRepository;
    }

    public function handle(IsActualUserAnOwnerCommand $isActualUserAnOwnerCommand): ?Owner
    {
        $fbDelegated = $isActualUserAnOwnerCommand->getActualFbDelegated();
        $searchOwnerByFbDelegatedHandler = new SearchOwnerByFbDelegatedHandler($this->mySQLOwnerRepository);
        try{
            $owner = $searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($fbDelegated));
        }
        catch (Exception $e)
        {
            return null;
        }
        return $owner;
    }
}