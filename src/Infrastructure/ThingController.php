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

/**
 * @Route("/thing", name="thing_")
 */
class ThingController extends Controller
{
    /**
     * @Route("/{thingId}", name="info", methods={"GET"})
     */
    public function info($thingId)
    {
//        dd($thingId);
        // TODO searchOwnerByFbDelegated as a service
        $ownerRepository = $this->get('app.repository.owner');
        $searchOwnerByFbDelegatedCommand = new SearchOwnerByFbDelegatedCommand(getenv('HC_FB_DELEGATED_OF_OWNER'));
        $searchOwnerByFbDelegatedHandler = new SearchOwnerByFbDelegatedHandler($ownerRepository);
        $owner = $searchOwnerByFbDelegatedHandler->handle($searchOwnerByFbDelegatedCommand);


        // TODO: pensar si pasar esto a Command-CommandHandler
        // given thingId belongs to Owner?
        try {
            $thing = $owner->getThingByIdOrException($thingId);
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }

        // TODO: get real facebook friends
        $friends= [['name' => 'name1'],['name'=>'name2']];

        return $this->render('Thing/info.html.twig', ['thing' => $thing, 'friends' => $friends]);
    }


    /**
     * @Route("/create", name="create", methods={"POST"})
     */
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

            $ownerRepository = $this->get('app.repository.owner');
            $owner = $ownerRepository->searchOwnerByfbDelegatedOrException(getenv('HC_FB_DELEGATED_OF_OWNER'));

            // add thing to owner
            $addThingCommand = new AddThingCommand($thing, $owner);
            $addThingHandler = new AddThingHandler($ownerRepository);

            $addThingHandler->handle($addThingCommand);

        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
        return new Response("HC thing created");
    }

    /**
     * @Route("/friends", name="friends", methods={"GET"})
     */
    public function friends()
    {
        return new Response('list of friends and delegated actions');
    }
}


