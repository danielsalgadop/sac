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

class OwnerController extends Controller
{
    private $createOwnerHandler;

    public function __construct(CreateOwnerHandler $createOwnerHandler)
    {
        $this->createOwnerHandler = $createOwnerHandler;
    }

    public function index(int $ownerFbDelegated)
    {
        return $this->render('Owner/info_owner.html.twig', ['ownerFbDelegated' => $ownerFbDelegated]);
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
