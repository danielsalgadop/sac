<?php


namespace App\Infrastructure\Controllers\Api\Owner;


use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetBasicInfo extends Controller
{
    private $searchOwnerByFbDelegatedHandler;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler)
    {
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
    }
    public function do(Request $request)
    {

        // voy a recibir un fb_delegated: TODO no usar este HC_FB_DELEGATED_OF_OWNER
        $fbDelegatedInSession= getenv('HC_FB_DELEGATED_OF_OWNER');

        $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($fbDelegatedInSession));

        return new JsonResponse($owner->toArray());
    }
}