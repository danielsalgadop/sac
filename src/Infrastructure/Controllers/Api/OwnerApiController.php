<?php


namespace App\Infrastructure\Controllers\Api;


use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use App\Infrastructure\Owner\Serializer\OwnerArraySeralizer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Infrastructure\Owner\Serializer\JsonSerializer;


class OwnerApiController extends Controller
{
    private $searchOwnerByFbDelegatedHandler;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler)
    {
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
    }

    public function info($fbDelegated)
    {
        // TODO, securizar este fbDelegated, ahora mismo con que exita en mi bbdd ya lo daré por bueno. Lo ideas sería
        // asegurar que la persona que me lo manda en realidad ES quien fb ha asignado ese fbDelegated

        try {
            $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($fbDelegated));
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }
        return new JsonResponse(OwnerArraySeralizer::serialize($owner));
    }
}