<?php

namespace App\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Application\CommandHandler\Thing\CreateThingHandler;
use App\Application\Command\Thing\CreateThingCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/thing", name="thing_")
 */
class ThingController extends Controller
{
    /**
     * @Route("/", name="info", methods={"GET"})
     */
    public function info()
    {
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
            $createThingCommand = new CreateThingCommand($root,$userName,$password);
            $createThingHandler->handle($createThingCommand);

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


