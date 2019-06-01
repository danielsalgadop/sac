<?php

namespace App\Infrastructure\Controllers;

use App\Application\Command\Thing\MergeThingWithThingConnectedByIdCommand;
use App\Application\CommandHandler\Thing\MergeThingWithThingConnectedByIdHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Application\Command\Thing\CreateThingCommand;
use App\Application\CommandHandler\Thing\CreateThingHandler;

use App\Application\Command\Owner\AddThingToOwnerCommand;
use App\Application\CommandHandler\Owner\AddThingToOwnerHandler;

use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;

use App\Application\Command\Owner\GetFbSharingStatusByOwnerCommand;
use App\Application\CommandHandler\Owner\GetFbSharingStatusByOwnerHandler;

class ThingController extends Controller
{
    private $searchOwnerByFbDelegatedHandler;
    private $getFbSharingStatusByOwnerHandler;
    private $createThingHandler;
    private $addThingToOwnerHandler;
    private $mergeThingWithThingConnectedByIdHandler;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler, GetFbSharingStatusByOwnerHandler $getFbSharingStatusByOwnerHandler, CreateThingHandler $createThingHandler, AddThingToOwnerHandler $addThingToOwnerHandler, MergeThingWithThingConnectedByIdHandler $mergeThingWithThingConnectedByIdHandler)
    {
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
        $this->getFbSharingStatusByOwnerHandler = $getFbSharingStatusByOwnerHandler;
        $this->createThingHandler = $createThingHandler;
        $this->addThingToOwnerHandler = $addThingToOwnerHandler;
        $this->mergeThingWithThingConnectedByIdHandler = $mergeThingWithThingConnectedByIdHandler;
    }

    public function info($thingId, Request $request)
    {

        $owner = $this->searchOwnerByFbDelegatedHandler->handle(
            new SearchOwnerByFbDelegatedCommand($request->getSession()->get('ownerFbDelegated')
            )
        );

        $sharingStatus = $this->getFbSharingStatusByOwnerHandler->handle(new GetFbSharingStatusByOwnerCommand($owner));

        // TODO: pensar si pasar esto a Command-CommandHandler
        // given thingId belongs to Owner?
        try {
            $thing = $owner->getThingByIdOrException($thingId);
        } catch (\Exception $e) {
            return $this->redirectToRoute('error',['message' => $e->getMessage()]);
        }

        // TODO: get real facebook friends
        $friends = [
            ['name' => 'name1_hc_in_controller',
                'actions' => [1, 2],
                'fdbDelegated' => '0_fbDelegated_friend_of_this_owner_id1'
            ],
            ['name' => 'name2_hc_in_controller', 'actions' => []]
        ];

        $this->mergeThingWithThingConnectedByIdHandler->handle(new MergeThingWithThingConnectedByIdCommand($thingId));

        return $this->render('Thing/info.html.twig', ['thing' => $thing, 'friends' => $friends, 'sharingStatus' => $sharingStatus, 'thingId' => $thingId]);
    }


    public function create(Request $request)
    {
        $root = $request->request->get('root');
        $userName = $request->request->get('user');
        $password = $request->request->get('password');

        try {
            $owner = $this->searchOwnerByFbDelegatedHandler->handle(
                new SearchOwnerByFbDelegatedCommand(
                    $request->getSession()->get('ownerFbDelegated')
                )
            );

            $thing = $this->createThingHandler->handle(new CreateThingCommand($root, $userName, $password));

            $this->addThingToOwnerHandler->handle(new AddThingToOwnerCommand($thing, $owner));

        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
        return $this->redirectToRoute('success',['message' => 'HC thing created']);
//        return new Response("");
    }

    // TODO: esta route se usa?
    /*
     * @Route("/friends", name="friends", methods={"GET"})
     */
    public function friends()
    {
        return new Response('list of friends and delegated actions');
    }
}


