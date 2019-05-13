<?php

namespace App\Infrastructure\Controllers;

use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\Command\Thing\CreateThingCommand;
use App\Application\CommandHandler\Owner\CreateOwnerHandler;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use App\Domain\Entity\Owner;
use App\Domain\Entity\Thing;
use App\Infrastructure\Owner\MySQLOwnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Command\Thing\GetThingConnectedInfoCommand;
use App\Application\CommandHandler\Thing\ThingConnected\GetThingConnectedNameHandler;
use App\Application\CommandHandler\Thing\ThingConnected\GetThingConnectedBrandHandler;
use App\Application\Command\Owner\CreateOwnerCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Contracts\Service;
use App\Domain\Repository\ThingConnectorRepository;
use Facebook\Facebook;

class OwnerController extends Controller
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

        $fbResponse = json_decode($request->cookies->get('fbResponse'));
        $connectFbResponse = json_decode($request->cookies->get('connectFbResponse'));

        $accessToken = $connectFbResponse->authResponse->accessToken;
        $ownerFbDelegated = $fbResponse->id;

//        file_put_contents("/tmp/debug.txt", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export($fbResponse, true) . PHP_EOL, FILE_APPEND);
//        file_put_contents("/tmp/debug.txt", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export($accessToken, true) . PHP_EOL, FILE_APPEND);
        // create Owner if not exists
        try {
            $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($ownerFbDelegated));
        } catch (\Exception $e) {
            // create Owner
            $this->createOwnerHandler->handle(new CreateOwnerCommand($fbResponse->name, $ownerFbDelegated));
        }

        try{
            $this->getSocialMediaUserOrException($accessToken);
        } catch (\Exception $e){
            dd("must do Error route ".$e->getMessage());
//            $this->redirectToRoute($route);
        }
        return $this->render('Owner/info_owner.html.twig', ['ownerFbDelegated' => $ownerFbDelegated]);
    }

    // Facebook coupled
    private function getSocialMediaUserOrException(string $accessToken)
    {
        $app_id = getenv('FACEBOOK_APP_ID');
        $app_secret = getenv('FACEBOOK_SECRET');
        $fb = new Facebook([
            'app_id' => $app_id,
            'app_secret' => $app_secret,
            'default_graph_version' => 'v3.3',
        ]);

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,name', $accessToken);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return new \Exception($e->getMessage());
//            echo 'Graph returned an error: ' . $e->getMessage();
//            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return new \Exception($e->getMessage());
//            echo 'Facebook SDK returned an error: ' . $e->getMessage();
//            exit;
        }

        $user = $response->getGraphUser();
        return $user;
//        echo 'Name: ' . $user['name'];
// OR
// echo 'Name: ' . $user->getName();
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
        foreach ([1, 2, 3] as $i) {
            $hardcodedFbFriend = new hardcodedFbFriend(100 + $i, "hard_coded_exclusiveFbFriend_" . $i . "_" . $fbDelegated);
            $exclusiveFbFriends[] = $hardcodedFbFriend;
        }
        return $exclusiveFbFriends;
    }
}


class hardcodedFbFriend
{
    public $id = null;
    public $fbDelegated = null;

    function __construct(int $id, $fbDelegated)
    {
        $this->id = $id;
        $this->fbDelegated = $fbDelegated;
    }

    function getId()
    {
        return $this->id;
    }

    function getFbDelegated()
    {
        return $this->fbDelegated;
    }
}
