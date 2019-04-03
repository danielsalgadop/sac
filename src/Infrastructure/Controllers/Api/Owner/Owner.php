<?php


namespace App\Infrastructure\Controllers\Api\Owner;


use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use App\Domain\Repository\ThingConnectedRepository;
use App\Infrastructure\Owner\Serializer\OwnerArraySeralizer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Infrastructure\Owner\Serializer\JsonSerializer;


class Owner extends Controller
{
    private $searchOwnerByFbDelegatedHandler;
    private $getThingConnectedNameHandler;
    private $thingConnectedRepository;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler, ThingConnectedRepository $thingConnectedRepository)
    {
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
        $this->thingConnectedRepository = $thingConnectedRepository;
//        $this->getThingConnectedNameHandler = $getThingConnectedNameHandler;
    }

    public function info(Request $request)
    {
        $fbDelegated = $request->query->get('fbDelegated') ?? ''; // TODO, revisar como recibir este fbDelegated

        try {
            $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($fbDelegated));
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }
        // DUDA Victor, he movido el JsonResponse dentro del JsonSerializer, ya que automáticamente "jsoniza" las estructuras de php. ¿es correcto esto?

        return new JsonResponse(OwnerArraySeralizer::serialize($owner));
    }

    public function getBasicInfo(Request $request)
    {

        $fbDelegated = $request->query->get('fbDelegated') ?? ''; // TODO, revisar como recibir este fbDelegated

        try {
            $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($fbDelegated));
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }

        return new JsonResponse($owner->toArray());
    }

    public function getListThings(Request $request)
    {
        $fbDelegated = $request->query->get('fbDelegated') ?? ''; // TODO, revisar como recibir este fbDelegated
        try {
            $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($fbDelegated));
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }

        return new JsonResponse($owner->getArrayOfThings($owner));
        $things = [];
        $i = 0;
//        foreach ($owner->getThings() as $thing) {
//            $thingId = $thing->getId();
//            $thingUserName = $thing->getUser();
//            $thingPassword = $thing->getPassword();
//             TODO: pasar esto a un servicio
//
//            $getThingConnectedInfoCommand = new GetThingConnectedInfoCommand($thingId, $thingUserName, $thingPassword);
//            $getThingNameHandler = new GetThingConnectedNameHandler();
//            $getThingBrandHandler = new GetThingConnectedBrandHandler();
//
//            $thingConnectorRepository = new ThingConnectorRepository();
//
//            $things[$i] = [
//                'id' => $thingId,
//                'connection' => false,
//                'name' => '',
//                'url' => '',
//                'brand' => '',
//            ];


        // TODO: no definir todo 2 veces, mejorar la manera de llenar things. se va a necesitar un contador para meter info del actual thing.
//            try {
//                $thingName = $this->getThingNameHandler->handle($getThingConnectedInfoCommand, $thingConnectorRepository);
//                $brandName = $getThingBrandHandler->handle($getThingConnectedInfoCommand, $thingConnectorRepository);
//                $things[$i] = [
//                    'id' => $thingId,
//                    'connection' => true,
//                    'name' => $thingName,
//                    'url' => 'usl_hard/coded/' . $thingId,
//                    'brand' => $brandName,
//                ];
//            } catch (\Exception $e) { //something whent wrong
//                $things[$i]['message'] = $e->getMessage();
//            }
//            $i++;
//        }


    }
}