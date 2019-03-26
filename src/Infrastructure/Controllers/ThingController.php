<?php

namespace App\Infrastructure\Controllers;

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

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler, GetFbSharingStatusByOwnerHandler $getFbSharingStatusByOwnerHandler, CreateThingHandler $createThingHandler, AddThingToOwnerHandler $addThingToOwnerHandler)
    {
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
        $this->getFbSharingStatusByOwnerHandler = $getFbSharingStatusByOwnerHandler;
        $this->createThingHandler = $createThingHandler;
        $this->addThingToOwnerHandler = $addThingToOwnerHandler;
    }

    public function info($thingId)
    {

        $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand(getenv('HC_FB_DELEGATED_OF_OWNER')));

        $sharingStatus = $this->getFbSharingStatusByOwnerHandler->handle(new GetFbSharingStatusByOwnerCommand($owner));

        // TODO: pensar si pasar esto a Command-CommandHandler
        // given thingId belongs to Owner?
        try {
            $thing = $owner->getThingByIdOrException($thingId);
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }

        // TODO: get real facebook friends
        $friends = [
            ['name' => 'name1_hc_in_controller',
                'actions' => [1, 2],
                'fdbDelegated' => '0_fbDelegated_friend_of_this_owner_id1'
            ],
            ['name' => 'name2_hc_in_controller', 'actions' => []]
        ];

        return $this->render('Thing/info.html.twig', ['thing' => $thing, 'friends' => $friends, 'sharingStatus' => $sharingStatus]);
    }


    public function create(Request $request)
    {
        $root = $request->request->get('root');
        $userName = $request->request->get('user');
        $password = $request->request->get('password');

        try {
            $thing = $this->createThingHandler->handle(new CreateThingCommand($root, $userName, $password));

            $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand(getenv('HC_FB_DELEGATED_OF_OWNER')));
            $this->addThingToOwnerHandler->handle(new AddThingToOwnerCommand($thing, $owner));

        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
        return new Response("HC thing created");
    }

    /*
     * @Route("/friends", name="friends", methods={"GET"})
     */
    public function friends()
    {
        return new Response('list of friends and delegated actions');
    }
}


