<?php

namespace App\Infrastructure\Controllers;

use App\Application\Command\Thing\MergeThingWithThingConnectedByIdCommand;
use App\Application\CommandHandler\Friend\CreateFriendHandler;
use App\Application\Command\Friend\CreateFriendCommand;
use App\Application\CommandHandler\Thing\MergeThingWithThingConnectedByIdHandler;
use App\Domain\Entity\Friend;
use App\Domain\Entity\Action;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

class ThingController extends AbstractController
{

    private $searchOwnerByFbDelegatedHandler;
    private $getFbSharingStatusByOwnerHandler;
    private $createThingHandler;
    private $addThingToOwnerHandler;
    private $mergeThingWithThingConnectedByIdHandler;
    private $createFriendHandler;

    public function __construct(
        SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler,
        GetFbSharingStatusByOwnerHandler $getFbSharingStatusByOwnerHandler,
        CreateThingHandler $createThingHandler,
        AddThingToOwnerHandler $addThingToOwnerHandler,
        MergeThingWithThingConnectedByIdHandler $mergeThingWithThingConnectedByIdHandler,
        CreateFriendHandler $createFriendHandler
    )
    {
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
        $this->getFbSharingStatusByOwnerHandler = $getFbSharingStatusByOwnerHandler;
        $this->createThingHandler = $createThingHandler;
        $this->addThingToOwnerHandler = $addThingToOwnerHandler;
        $this->mergeThingWithThingConnectedByIdHandler = $mergeThingWithThingConnectedByIdHandler;
        $this->createFriendHandler = $createFriendHandler;
    }

    public function info($thingId, Request $request)
    {

        $owner = $this->searchOwnerByFbDelegatedHandler->handle(
            new SearchOwnerByFbDelegatedCommand($request->getSession()->get('ownerFbDelegated')
            )
        );

        /** @var GetFbSharingStatusByOwnerHandler $sharingStatus */
        $sharingStatus = $this->getFbSharingStatusByOwnerHandler->handle(new GetFbSharingStatusByOwnerCommand($owner));

        // TODO: pensar si pasar esto a Command-CommandHandler
        // given thingId belongs to Owner?
        try {
            $thing = $owner->getThingByIdOrException($thingId);
//            dd($thing);
        } catch (\Exception $e) {
            return $this->redirectToRoute('error', ['message' => $e->getMessage()]);
        }


        // TODO: move this to owner:info. Tengo que añadir la columna name
        $session = $request->getSession();
        $friends = $session->get('fbFriends');
        $friendsAsObj = json_decode($friends->getBody());
        $friendsForView = [];
        foreach ($friendsAsObj->data as $friend) {
            $owner->addFriend($this->createFriendHandler->handle(new CreateFriendCommand($friend->id)));
        }

//        dd($owner);
        $friends  = $owner->getFriends();

//        dd(count($friends));
        /** @var $friend Friend*/
        foreach ($friends as $friend){
            $oneFriend = [];
            $oneFriend['name'] = "FriendnameeeeTODO".$friend->getFbDelegated();
            $oneFriend['fbDelegated'] = $friend->getFbDelegated();

            $actionsIdList = [];
            /** @var $action Action */
            foreach ($friend->getActions() as $action) {
                $actionsIdList[] = $action->getId();
            }
            $oneFriend['actions'] = $actionsIdList;

            $friendsForView[] = $oneFriend;
        }
//        dd($friendsForView);

//        dd($friendsForView);


        //            dd($friendsForView);
//        $friends = [
//            ['name' => 'name1_hc_in_controller',
//                'actions' => [1, 2],
//                'fdbDelegated' => '0_fbDelegated_friend_of_this_owner_id1'
//            ],
//            ['name' => 'name2_hc_in_controller', 'actions' => []]
//        ];
//        dd($friendsForView);
        $this->mergeThingWithThingConnectedByIdHandler->handle(new MergeThingWithThingConnectedByIdCommand($thingId));


//        $thingConnected = $thing->getThingConnected();
        // persistActions

//    dd($friendsForView);
        return $this->render('Thing/info.html.twig', ['thing' => $thing, 'friends' => $friendsForView, 'sharingStatus' => $sharingStatus, 'thingId' => $thingId]);
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
        return $this->redirectToRoute('success', ['message' => 'HC thing created']);
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


