<?php

namespace App\Infrastructure\Controllers;

use App\Application\Command\Thing\MergeThingWithThingConnectedByIdCommand;
use App\Application\CommandHandler\Action\CreateActionHandler;
use App\Application\CommandHandler\Friend\CreateFriendHandler;
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
use App\Application\Command\Action\CreateActionCommand;
use \Exception;

class ThingController extends AbstractController implements HasFbSessionController
{

    private $searchOwnerByFbDelegatedHandler;
    private $getFbSharingStatusByOwnerHandler;
    private $createThingHandler;
    private $addThingToOwnerHandler;
    private $mergeThingWithThingConnectedByIdHandler;
    private $createFriendHandler;
    private $createActionHandler;

    public function __construct(
        SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler,
        GetFbSharingStatusByOwnerHandler $getFbSharingStatusByOwnerHandler,
        CreateThingHandler $createThingHandler,
        AddThingToOwnerHandler $addThingToOwnerHandler,
        MergeThingWithThingConnectedByIdHandler $mergeThingWithThingConnectedByIdHandler,
        CreateFriendHandler $createFriendHandler,
        CreateActionHandler $createActionHandler
    )
    {
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
        $this->getFbSharingStatusByOwnerHandler = $getFbSharingStatusByOwnerHandler;
        $this->createThingHandler = $createThingHandler;
        $this->addThingToOwnerHandler = $addThingToOwnerHandler;
        $this->mergeThingWithThingConnectedByIdHandler = $mergeThingWithThingConnectedByIdHandler;
        $this->createFriendHandler = $createFriendHandler;
        $this->createActionHandler = $createActionHandler;
    }

    public function info($thingId, Request $request)
    {

        $owner = $this->searchOwnerByFbDelegatedHandler->handle(
            new SearchOwnerByFbDelegatedCommand($request->getSession()->get('ownerFbDelegated')
            )
        );

        /** @var GetFbSharingStatusByOwnerHandler $sharingStatus */
        $sharingStatus = $this->getFbSharingStatusByOwnerHandler->handle(new GetFbSharingStatusByOwnerCommand($owner));

        try {
            $thing = $owner->getThingByIdOrException($thingId);
        } catch (Exception $e) {
            return $this->redirectToRoute('error', ['message' => $e->getMessage()]);
        }

        $friends  = $owner->getFriends();

        /** @var $friend Friend*/
        foreach ($friends as $friend){
            $oneFriend = [];
            $oneFriend['name'] = $friend->getName();
            $oneFriend['fbDelegated'] = $friend->getFbDelegated();
            $oneFriend['friendId'] = $friend->getId();

            $actionsIdList = [];
            /** @var $action Action */
            foreach ($friend->getActions() as $action) {
                $actionsIdList[] = $action->getId();
            }
            $oneFriend['actions'] = $actionsIdList;

            $friendsForView[] = $oneFriend;
        }



        $this->mergeThingWithThingConnectedByIdHandler->handle(new MergeThingWithThingConnectedByIdCommand($thingId));



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

        } catch (Exception $e) {
            return new Response($e->getMessage());
        }
        return $this->redirectToRoute('success', ['message' => 'HC thing created']);
    }
}


