<?php

namespace App\Infrastructure;

use App\Application\Command\Thing\CreateThingCommand;
use App\Application\CommandHandler\Owner\CreateOwnerHandler;
use App\Domain\Entity\Owner;
use App\Infrastructure\Owner\MySQLOwnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Command\Owner\CreateOwnerCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Contracts\Service;


/** TODO: hacer prefix e todo controller (no te olvides de poner doble asterisco aqui)
* https://symfony.com/blog/new-in-symfony-3-4-prefix-all-controller-route-names
 * @Route("/owner", name="owner_")
 */
class OwnerController extends Controller
{
    /**
     * @Route("/", name="info_user", methods={"GET"})
     */
    public function info()
    {
        return new Response('info about user');
    }



    /**
     * @Route("/create", name="create", methods={"GET"})
     * TODO: POST (not GET)
     */
    public function create()
    {
        try {
//            $mysqlOwnerRepository = $this->get('app.repository.owner');
//            $createOwnerHandler = new CreateOwnerHandler($mysqlOwnerRepository);
//            $createOwnerCommand = new CreateOwnerCommand("hardcoded", "fb_delegated_hardcoded");
//            $createOwnerHandler->handle($createOwnerCommand);

        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
         return new Response("HC owner created");
    }


    /**
     * @Route("/things", name="things", methods={"GET"})
     */
    public function things()
    {
        return new Response('list of things owned by user');
    }


    /**
     * @Route("/friends", name="friends", methods={"GET"})
     */
    public function friends()
    {
        return new Response('list of friends and delegated actions');
    }
}


