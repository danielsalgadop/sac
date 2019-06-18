<?php

namespace App\Infrastructure\Controllers;

use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\CreateOwnerHandler;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use Assetic\Filter\HashableInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Application\CommandHandler\Thing\ThingConnected\GetThingConnectedNameHandler;
use App\Application\CommandHandler\Thing\ThingConnected\GetThingConnectedBrandHandler;
use App\Application\Command\Owner\CreateOwnerCommand;
use App\Domain\Repository\ThingConnectorRepository;
use Facebook\Facebook;

class OwnerController extends AbstractController
{
    private $createOwnerHandler;
    private $searchOwnerByFbDelegatedHandler;

    public function __construct(CreateOwnerHandler $createOwnerHandler, SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler)
    {
        $this->createOwnerHandler = $createOwnerHandler;
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
    }

    public function index(Request $request)
    {
        // fbResponse exists?
        if (!$request->cookies->has('fbResponse')) {
            return $this->redirectToRoute('login');
        }

        // TODO Victor: fbResponse, usamos id y name
        $fbResponse = json_decode($request->cookies->get('fbResponse'));
//        dd($fbResponse);
        $connectFbResponse = json_decode($request->cookies->get('connectFbResponse'));

        $accessToken = $connectFbResponse->authResponse->accessToken;
        $ownerFbDelegated = $fbResponse->id;

        //
        try{
            $friends = $this->hasSocialMediaUserOrException($accessToken);
        } catch (\Exception $e) {
            return $this->redirectToRoute('login');
        }


        // create Owner if not exists in sac
        try {
            $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($ownerFbDelegated));
        } catch (\Exception $e) {
            // create Owner
            $this->createOwnerHandler->handle(new CreateOwnerCommand($fbResponse->name, $ownerFbDelegated));
        }

        $session = $request->getSession();
        $session->start();
//        dd($session->isStarted());
        $session->set('ownerFbDelegated',$ownerFbDelegated);
        $session->set('accessToken',$accessToken);
        $session->set('fbFriends',$friends);

        // sending ownerFbDelegated via session: return $this->render('Owner/info_owner.html.twig', ['ownerFbDelegated' => 70]);
        return $this->render('Owner/info_owner.html.twig');
    }

    // Facebook coupled
    private function hasSocialMediaUserOrException(string $accessToken)
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
        return $friends;
        // en esta respuesta tengo 'body' (en json) o decodedBody con cada amigo en 1 array
    }


    public function create(Request $request)
    {
        $name = $request->request->get('name');
        $fbDelegated = $request->request->get('fbDelegated');

        $name = filter_var($name ?? '', FILTER_SANITIZE_STRING);

        try {
            $this->createOwnerHandler->handle(new CreateOwnerCommand($name, $fbDelegated));

        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
        return new Response("HC owner created");
    }


    public function things()
    {
        return new Response('list of things owned by user');
    }


    public function friends()
    {
//        dd("dfdd");
        $ownerFbDelegated = getenv('HC_FB_DELEGATED_OF_OWNER');
        $searchOwnerByFbDelegatedCommand = new SearchOwnerByFbDelegatedCommand($ownerFbDelegated);
        $searchOwnerByFbDelegatedHandler = $this->get('app.command_handler.owner.search.by_fb_delegated');
        try {
            $owner = $searchOwnerByFbDelegatedHandler->handle($searchOwnerByFbDelegatedCommand);
        } catch (\Exception $e) {
            // TODO se podría recoger el valor del error y pasarlo como mensaje al login
            return $this->redirect($this->generateUrl('login'));
        }

        $totalFriends = array_merge($this->hardcodedFbFriend($ownerFbDelegated), $owner->getFriends()->toArray());

        return $this->render(
            'Owner/friends.html.twig', [
                'friends' => $totalFriends,
            ]
        );
    }

    // TODO: thins info will be fetched from facebook
    private function hardcodedFbFriend(string $fbDelegated): array
    {
//        foreach ([1, 2, 3] as $i) {
//            $hardcodedFbFriend = new hardcodedFbFriend(100 + $i, "hard_coded_exclusiveFbFriend_" . $i . "_" . $fbDelegated);
//            $exclusiveFbFriends[] = $hardcodedFbFriend;
//        }
//        return $exclusiveFbFriends;
    }
}
