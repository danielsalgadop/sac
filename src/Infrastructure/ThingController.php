<?php

namespace App\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Application\Command\Thing\CreateThingCommand;
use App\Application\CommandHandler\Thing\CreateThingHandler;

use App\Application\Command\Owner\AddThingCommand;
use App\Application\CommandHandler\Owner\AddThingHandler;

use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;

use App\Application\Command\Owner\GetFbSharingStatusByOwnerCommand;
use App\Application\CommandHandler\Owner\GetFbSharingStatusByOwnerHandler;

class ThingController extends Controller
{
    public function info($thingId)
    {
//        dd($thingId);
        // TODO quitar este app.repository.owner cuando GetFbSharingStatusByOwnerHandler as as service
        $ownerRepository = $this->get('app.repository.owner');

        $searchOwnerByFbDelegatedCommand = new SearchOwnerByFbDelegatedCommand(getenv('HC_FB_DELEGATED_OF_OWNER'));
        $searchOwnerByFbDelegatedHandler = $this->get('app.command_handler.owner.search.by_fb_delegated');
        $owner = $searchOwnerByFbDelegatedHandler->handle($searchOwnerByFbDelegatedCommand);

        $getFbSharingStatusByOwnerCommand = new GetFbSharingStatusByOwnerCommand($owner);
        $getFbSharingStatusByOwnerHandler = new GetFbSharingStatusByOwnerHandler($ownerRepository);

        $sharingStatus = $getFbSharingStatusByOwnerHandler->handle($getFbSharingStatusByOwnerCommand);

        // actual sharingStatus
//        {"1":{"1":["0_fbDelegated_friend_of_this_owner_id1"],"2":["0_fbDelegated_friend_of_this_owner_id1"]},"2":[]}

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
            $mysqlThingRepository = $this->get('app.repository.thing');
            $createThingHandler = new CreateThingHandler($mysqlThingRepository);
            $createThingCommand = new CreateThingCommand($root, $userName, $password);
            $thing = $createThingHandler->handle($createThingCommand);



            $searchOwnerByFbDelegatedCommand = new SearchOwnerByFbDelegatedCommand(getenv('HC_FB_DELEGATED_OF_OWNER'));
            $searchOwnerByFbDelegatedHandler = $this->get('app.command_handler.owner.search.by_fb_delegated');
            $owner = $searchOwnerByFbDelegatedHandler->handle($searchOwnerByFbDelegatedCommand);

            // add thing to owner
            $addThingCommand = new AddThingCommand($thing, $owner);
            // TODO AddThingHandler as a service
            $addThingHandler = new AddThingHandler($this->get('app.repository.owner'));

            $addThingHandler->handle($addThingCommand);

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


