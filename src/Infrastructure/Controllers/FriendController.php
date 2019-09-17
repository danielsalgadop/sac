<?php


namespace App\Infrastructure\Controllers;

//use App\Application\Command\Friend\CreateFriendCommand;
use App\Application\Command\Friend\SearchFriendByFbDelegatedCommand;
//use App\Application\Command\Friend\SearchFriendByIdCommand;
//use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Friend\SearchFriendByFbDelegatedHandler;
//use App\Application\CommandHandler\Friend\SearchFriendByIdHandler;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\CommandHandler\Thing\ThingConnected\GetThingConnectedCompleteHandler;
use App\Domain\Entity\Action;
use App\Domain\Entity\Friend;
use App\Domain\Entity\Owner;
use Exception;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FriendController extends AbstractController implements HasFbSessionController
{

    private $searchThingByIdHandler;
    private $searchFriendByFbDelegatedHandler;
    private $getThingConnectedCompleteHandler;

    public function __construct(
        SearchThingByIdHandler $searchThingByIdHandler,
        SearchFriendByFbDelegatedHandler $searchFriendByFbDelegatedHandler,
        GetThingConnectedCompleteHandler $getThingConnectedCompleteHandler
    )
    {

        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->searchFriendByFbDelegatedHandler = $searchFriendByFbDelegatedHandler;
        $this->getThingConnectedCompleteHandler = $getThingConnectedCompleteHandler;
    }

    public function showAction(int $actionId, int $thingId, Request $request)
    {

        // TODO rename ownerFbDelegated, because here it is NOT owner's but friend's. Should be userLoggedFbDelegated
        $friendFbDelegated = $request->getSession()->get('ownerFbDelegated');

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

                                    if ($action->getName() === $actionName) {

                                        return new JsonResponse($value->values);
                                    }

                                }
                            }
                        }
                    }
                }
            }

        } catch (Exception $e) {
            return new JsonResponse("Resource not found", 200);
        }
        return new JsonResponse("Resource not found", 200);
    }

    public function info(Request $request)
    {
        $session = $request->getSession();
        $sessionFbDelegated = $session->get('ownerFbDelegated');
        $friend = $this->searchFriendByFbDelegatedHandler->handle(new SearchFriendByFbDelegatedCommand($sessionFbDelegated));


        $accessToken = $session->get('accessToken');

        $fbAppId = getenv('FACEBOOK_APP_ID');
        $fbSecret = getenv('FACEBOOK_SECRET');
        $fb = new Facebook([
            'app_id' => $fbAppId,
            'app_secret' => $fbSecret,
            'default_graph_version' => 'v3.3',
        ]);

        try{
            $response = $fb->get('/me?fields=id,name', $accessToken);
            $user = $response->getGraphUser();
        }
        catch (FacebookSDKException $e){
            return $this->redirectToRoute('login');
        }

        $owners = $friend->getOwners();
        /** @var Owner $owner */
        $owner = $owners->first();
        $response = $this->render('Friend/friend_info.html.twig', ['friend' => $friend, 'ownerName' => $owner->getName()]);
        $response->headers->clearCookie('fbResponse');
        $response->headers->clearCookie('connectFbResponse');
        return $response;
    }
}