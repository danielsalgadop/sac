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
use App\Application\Command\Thing\getThingConnectedInfoCommand;
use App\Application\CommandHandler\Thing\ThingConnected\getThingConnectedNameHandler;
use App\Application\CommandHandler\Thing\ThingConnected\getThingConnectedBrandHandler;
use App\Application\Command\Owner\CreateOwnerCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Contracts\Service;
use App\Domain\Repository\ThingConnectorRepository;

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
        // voy a recibir un fb_delegated: TODO no usar este HC_FB_DELEGATED_OF_OWNER
        $hc_fb_delegated = getenv('HC_FB_DELEGATED_OF_OWNER');
        // Intentando usar el Repo desde aqui, el controller
//        $ownerRepo = $this->getDoctrine()->getRepository(Owner::class);
//        $owner = $ownerRepo->findOneBy(['fbDelegated' => $hc_fb_delegated]);

//        TODO: no consigo buscar algo distinto al id
        // TODO: pasar esto como servicio, sirve para identificar fbDelegated válidos (para autenticar)
        $mysqlOwnerRepository = $this->get('app.repository.owner');
        $searchOwnerByFbDelegatedHandler = new SearchOwnerByFbDelegatedHandler($mysqlOwnerRepository);
        $searchOwnerByFbDelegatedCommand = new SearchOwnerByFbDelegatedCommand($hc_fb_delegated);
        try {
            $owner = $searchOwnerByFbDelegatedHandler->handle($searchOwnerByFbDelegatedCommand);
        } catch (\Exception $e) {
            // TODO se podría recoger el valor del error y pasarlo como mensaje al login
            return $this->redirect($this->generateUrl('login'));
        }

        $things = [];
        $i = 0;
        foreach ($owner->getThings() as $thing) {
            $thingId = $thing->getId();
            $thingUserName = $thing->getUser();
            $thingPassword = $thing->getPassword();
            // TODO: pasar esto a un servicio

            $getThingConnectedInfoCommand = new getThingConnectedInfoCommand($thingId, $thingUserName, $thingPassword);
            $getThingNameHandler = new getThingConnectedNameHandler();
            $getThingBrandHandler = new getThingConnectedBrandHandler();

            $thingConnectorRepository = new ThingConnectorRepository();

            $things[$i] = [
                'id' => $thingId,
                'connection' => false,
                'name' => '',
                'url' => '',
                'brand' => '',
            ];


            // TODO: no definir todo 2 veces, mejorar la manera de llenar things. se va a necesitar un contador para meter info del actual thing.
            try {
                $thingName = $getThingNameHandler->handle($getThingConnectedInfoCommand, $thingConnectorRepository);
                $brandName = $getThingBrandHandler->handle($getThingConnectedInfoCommand, $thingConnectorRepository);
                $things[$i] = [
                    'id' => $thingId,
                    'connection' => true,
                    'name' => $thingName,
                    'url' => 'usl_hard/coded/' . $thingId,
                    'brand' => $brandName,
                ];
            } catch (\Exception $e) { //something whent wrong
                $things[$i]['message'] = $e->getMessage();
            }
            $i++;
        }
        $friends = $owner->getFriends();
//        dd($friends->getValues());
        return $this->render(
            'Owner/info_owner.html.twig', [
                'complete_name' => 'nombre_hc_controller',
                'things' => $things,
                'friends' => $friends,
            ]
        );
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


