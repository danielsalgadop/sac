<?php


namespace App\Application\CommandHandler\Owner;

use App\Application\Command\Owner\IsActualUserAnOwnerCommand;
use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Domain\Entity\Owner;
use App\Infrastructure\Owner\MySQLOwnerRepository;
use \Exception;

class IsActualUserAnOwnerHandler
{
    private $searchOwnerByFbDelegatedHandler;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler)
    {
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
    }

    public function handle(IsActualUserAnOwnerCommand $isActualUserAnOwnerCommand): ?Owner
    {
        $fbDelegated = $isActualUserAnOwnerCommand->getActualFbDelegated();
        try{
            $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($fbDelegated));
        }
        catch (Exception $e)
        {
            return null;
        }
        return $owner;
    }
}