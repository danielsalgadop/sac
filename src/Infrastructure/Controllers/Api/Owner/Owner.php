<?php


namespace App\Infrastructure\Controllers\Api\Owner;


use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use App\Infrastructure\Owner\Serializer\OwnerArraySeralizer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Owner\Serializer\JsonSerializer;


class Owner extends Controller
{
    private $searchOwnerByFbDelegatedHandler;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler)
    {
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
    }

    public function info(Request $request)
    {
        $fbDelegated = $request->query->get('fbDelegated') ?? ''; // TODO, revisar como recibir este fbDelegated

        try {
            $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($fbDelegated));
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }
        return new JsonResponse(OwnerArraySeralizer::serialize($owner));
    }
}