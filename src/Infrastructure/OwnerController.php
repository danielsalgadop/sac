<?php

namespace App\Infrastructure;

use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\Command\Thing\CreateThingCommand;
use App\Application\CommandHandler\Owner\CreateOwnerHandler;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
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


/**
 * @Route("/owner", name="owner_")
 */
class OwnerController extends Controller
{
    /**
     * @Route("/", name="info_owner", methods={"GET"})
     */
    public function info_owner()
    {
        // voy a recibir un fb_delegated
        $hc_fb_delegated = "fb_delegated_1";

        // Intentando usar el Repo desde aqui, el controller
//        $owner = $this->getDoctrine()->getRepository(MySQLOwnerRepository::class)->findOneBy(['fb_delegated' => $hc_fb_delegated]);

//        TODO: no consigo buscar algo distinto a 1 id
        $mysqlOwnerRepository = $this->get('app.repository.owner');
        $searchOwnerByFbDelegatedHandler = new SearchOwnerByFbDelegatedHandler($mysqlOwnerRepository);
        $searchOwnerByFbDelegatedCommand = new SearchOwnerByFbDelegatedCommand($hc_fb_delegated);
        $owner = $searchOwnerByFbDelegatedHandler->handle($searchOwnerByFbDelegatedCommand);

        $things = $owner->getThings();

        // hc things
        $things = [];
        foreach ([1,2,3] as $i){
            $thing['name'] = 'thing_HC_in_controller'.$i;
            $thing['url'] = 'url_/hard/coded/'.$i;  // TODO: generateUrl();
            $things[] = $thing;
        }

        return $this->render('Owner/info_owner.html.twig', ['complete_name' => 'nombre_hc_controller','things' => $things]);
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


