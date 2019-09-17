<?php

namespace App\Infrastructure\Controllers;

use App\Application\Command\Friend\CreateFriendCommand;
use App\Application\Command\Friend\SearchFriendByFbDelegatedCommand;
use App\Application\Command\Owner\CreateOwnerCommand;
use App\Application\Command\Owner\IsActualUserAnOwnerCommand;
use App\Application\CommandHandler\Friend\CreateFriendHandler;
use App\Application\CommandHandler\Friend\SearchFriendByFbDelegatedHandler;
use App\Application\CommandHandler\Owner\CreateOwnerHandler;
use App\Application\CommandHandler\Owner\IsActualUserAnOwnerHandler;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use App\Application\CommandHandler\Thing\ThingConnected\GetThingConnectedBrandHandler;
use App\Application\CommandHandler\Thing\ThingConnected\GetThingConnectedNameHandler;
use App\Domain\Entity\Owner;
use App\Domain\Repository\ThingConnectorRepository;
use App\Infrastructure\Owner\MySQLOwnerRepository;
use Facebook\Facebook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnerController extends AbstractController
{
    private $createOwnerHandler;
    private $searchOwnerByFbDelegatedHandler;
    private $isActualUserAnOwnerHandler;
    private $mySQLOwnerRepository;
    private $searchFriendByFbDelegatedHandler;
    private $createFriendHandler;

    public function __construct(
        CreateOwnerHandler $createOwnerHandler,
        SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler,
        IsActualUserAnOwnerHandler $isActualUserAnOwnerHandler,
        MySQLOwnerRepository $mySQLOwnerRepository,
        SearchFriendByFbDelegatedHandler $searchFriendByFbDelegatedHandler,
        CreateFriendHandler $createFriendHandler
    )
    {
        $this->createOwnerHandler = $createOwnerHandler;
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
        $this->isActualUserAnOwnerHandler = $isActualUserAnOwnerHandler;
        $this->mySQLOwnerRepository = $mySQLOwnerRepository;
        $this->searchFriendByFbDelegatedHandler = $searchFriendByFbDelegatedHandler;
        $this->createFriendHandler = $createFriendHandler;
    }

    public function index(Request $request)
    {
        $session = $request->getSession();

        if (!$request->cookies->has('fbResponse') && !$request->cookies->has('connectFbResponse') &&  !$session->get('ownerFbDelegated')){
            return $this->redirectToRoute('login');
        }

        $ownerFbDelegated = null;

        if($request->cookies->has('fbResponse') && $request->cookies->has('connectFbResponse')) {
            $fbResponse = json_decode($request->cookies->get('fbResponse'));
            $connectFbResponse = json_decode($request->cookies->get('connectFbResponse'));
            $accessToken = $connectFbResponse->authResponse->accessToken;
            $ownerFbDelegated = $fbResponse->id;

            $session->start();
            $session->set('ownerFbDelegated',$ownerFbDelegated);
            $session->set('accessToken',$accessToken);
        }else {
            $ownerFbDelegated = $session->get('ownerFbDelegated');
        }

        // only 1 owner for application allowed
        $appHasOwner = $this->mySQLOwnerRepository->find(1);

        $owner = null;
        if ($appHasOwner) {
            $owner = $this->isActualUserAnOwnerHandler->handle(new IsActualUserAnOwnerCommand($ownerFbDelegated));
        } else { // actual user will be owner
            try {
                $owner = $this->createOwnerHandler->handle(new CreateOwnerCommand($fbResponse->name, $ownerFbDelegated));
                try {
                    $friends = $this->getAndAddFriendsToOwner($accessToken, $owner);
                } catch (\Exception $e) {
                    return $this->redirectToRoute('login');
                }

            } catch (\Exception $e) {
                return $this->redirectToRoute('error', ['message' => $e->getMessage()]);
            }
        }

        if ($owner === null) {
            try {
                $friend = $this->searchFriendByFbDelegatedHandler->handle(new SearchFriendByFbDelegatedCommand($ownerFbDelegated));
            } catch (\Exception $e) { // not a friend of owner
                return $this->redirectToRoute('login');
            }
            return $this->redirectToRoute('friend_info');
        }

        // sending ownerFbDelegated via session: return $this->render('Owner/info_owner.html.twig', ['ownerFbDelegated' => 70]);
        $response = $this->render('Owner/info_owner.html.twig');
        $response->headers->clearCookie('fbResponse');
        $response->headers->clearCookie('connectFbResponse');
        return $response;
    }

    // Facebook coupled
    private function getAndAddFriendsToOwner(string $accessToken, Owner $owner)
    {
        $fbAppId = getenv('FACEBOOK_APP_ID');
        $fbSecret = getenv('FACEBOOK_SECRET');

        $fb = new Facebook([
            'app_id' => $fbAppId,
            'app_secret' => $fbSecret,
            'default_graph_version' => 'v3.3',
        ]);

        $response = $fb->get('/me?fields=id,name', $accessToken);
        $user = $response->getGraphUser();

        // How to get friend list
        $friends = $fb->get('/'.$user->getId().'/friends',$accessToken);

        // add friends to database
        $friendsAsArray = $friends->getDecodedBody();
        foreach ($friendsAsArray['data'] as $fbFriend) {
            $owner->addFriend($this->createFriendHandler->handle(new CreateFriendCommand($fbFriend['id'], $fbFriend['name'])));
        }
        $this->mySQLOwnerRepository->save($owner);

        return $friends;
    }



    // Se usa?
//    public function create(Request $request)
//    {
//        $name = $request->request->get('name');
//        $fbDelegated = $request->request->get('fbDelegated');
//
//        $name = filter_var($name ?? '', FILTER_SANITIZE_STRING);
//
//        try {
//            $this->createOwnerHandler->handle(new CreateOwnerCommand($name, $fbDelegated));
//
//        } catch (\Exception $e) {
//            return new Response($e->getMessage());
//        }
//        return new Response("HC owner created");
//    }

//    public function things()
//    {
//        return new Response('list of things owned by user');
//    }
}
