<?php


namespace App\Infrastructure\Controllers;

use App\Application\Command\Friend\SearchFriendByFbDelegatedCommand;
use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Friend\SearchFriendByFbDelegatedHandler;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\CommandHandler\Thing\ThingConnected\GetThingConnectedCompleteHandler;
use App\Domain\Entity\Action;
use App\Domain\Entity\Friend;
use App\Infrastructure\ThingConnected\Serializer\ThingConnectedSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Exception;
use Symfony\Component\HttpFoundation\Response;

class FriendController extends AbstractController implements HasFbSessionController
{

    private $searchThingByIdHandler;
    private $searchFriendByFbDelegatedHandler;
    private $getThingConnectedCompleteHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler, SearchFriendByFbDelegatedHandler $searchFriendByFbDelegatedHandler, GetThingConnectedCompleteHandler $getThingConnectedCompleteHandler)
    {

        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->searchFriendByFbDelegatedHandler = $searchFriendByFbDelegatedHandler;
        $this->getThingConnectedCompleteHandler = $getThingConnectedCompleteHandler;
    }

    public function showAction(int $actionId, int $thingId, Request $request)
    {

        // TODO rename ownerFbDelegated, because here it is NOT owner's but friend's. Should be userLoggedFbDelegated
        $friendFbDelegated = $request->getSession()->get('ownerFbDelegated');
//        $friendFbDelegated = 101658664356739;
        try {

            $loggedFriend = $this->searchFriendByFbDelegatedHandler->handle(new SearchFriendByFbDelegatedCommand($friendFbDelegated));
            $thing = $this->searchThingByIdHandler->handle(new SearchThingByIdCommand($thingId));

            /** @var Action $action */
            foreach ($thing->getActions() as $action) {
                if ($actionId === $action->getId()) {
                    /** @var Friend $friend */
                    foreach ($action->getFriends() as $friend) {

                        if ($loggedFriend === $friend) {

                            $thingConnected = $this->getThingConnectedCompleteHandler->handle(new GetThingConnectedInfoCommand($thing->getId(), $thing->getUser(), $thing->getPassword()));
                            $actions = $thingConnected['data']->links;
                            foreach ($actions as $foo) {
                                foreach ($foo->resources as $actionName => $value) {

                                    if ($action->getRoute() === $actionName) {

                                        return new JsonResponse($value->values);
                                    }

                                }
                            }
                        }
                    }
                }
            }

        } catch (Exception $e) {
//            return new JsonResponse("Resource not found ---error---" . $e->getMessage(), 200);
            return new JsonResponse("Resource not found", 200);
        }
        return new JsonResponse("Resource not found", 200);
        return new JsonResponse('actionId ' . $actionId . ' thingId ' . $thingId . ' ownerFbDelegated [' . $ownerFbDelegated . ']', 200);
    }
}