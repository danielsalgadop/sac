<?php

namespace App\Infrastructure;

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
use App\Application\Command\Thing\getThingNameCommand;
use App\Application\CommandHandler\Thing\getThingNameHandler;
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
        $ownerRepo = $this->getDoctrine()->getRepository(Owner::class);
        $owner = $ownerRepo->findOneBy(['fbDelegated' => $hc_fb_delegated]);
//        $owner = $ownerRepo->find(1);

//        TODO: no consigo buscar algo distinto al id
//        $mysqlOwnerRepository = $this->get('app.repository.owner');
//        $searchOwnerByFbDelegatedHandler = new SearchOwnerByFbDelegatedHandler($mysqlOwnerRepository);
//        $searchOwnerByFbDelegatedCommand = new SearchOwnerByFbDelegatedCommand($hc_fb_delegated);
//        $owner = $searchOwnerByFbDelegatedHandler->handle($searchOwnerByFbDelegatedCommand);

        $array_of_things = [];
        foreach($owner->getThings() as $thing){
            $id_thing = $thing->getId();
            $thing_username = $thing->getUser();
            $thing_password = $thing->getPassword();
            // TODO: pasar esto a un servicio
            $getThingNameCommand = new getThingNameCommand($id_thing, $thing_username, $thing_password);
            $getThingNameHandler = new getThingNameHandler();
            $thing_name = $getThingNameHandler->handle($getThingNameCommand); // Voy a tener que llamar a iot_emulator para sacar el nombre del thing

            $array_of_things[] = ['name' => $thing_name, 'url'=> 'usl_hard/coded/'.$id_thing]; //$thing_name;
        }

        return $this->render('Owner/info_owner.html.twig', ['complete_name' => 'nombre_hc_controller','things' => $array_of_things]);
    }


    /**
     * @Route("/create", name="create", methods={"GET"})
     * TODO: POST (not GET)
     */
    public function create()
    {
        // TODO get parameters
        try {
            $mysqlOwnerRepository = $this->get('app.repository.owner');
            $createOwnerHandler = new CreateOwnerHandler($mysqlOwnerRepository);
            $createOwnerCommand = new CreateOwnerCommand("hardcoded", "fb_delegated_hardcoded");
            $createOwnerHandler->handle($createOwnerCommand);

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


