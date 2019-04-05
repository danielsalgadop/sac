<?php


namespace App\Infrastructure\Controllers\Api;


use App\Application\Command\Thing\MergeThingWithThingConnectedByIdCommand;
use App\Application\CommandHandler\Thing\MergeThingWithThingConnectedByIdHandler;
use App\Infrastructure\Thing\Serializer\ThingWithThingConnectedArraySerializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Infrastructure\Owner\Serializer\JsonSerializer;


class ThingApiController extends Controller
{

    private $mergeThingWithThingConnectedByIdHandler;

    public function __construct(MergeThingWithThingConnectedByIdHandler $mergeThingWithThingConnectedByIdHandler)
    {
        $this->mergeThingWithThingConnectedByIdHandler = $mergeThingWithThingConnectedByIdHandler;
    }

    public function info($thingId)
    {
        // TODO, securizar esto para que solo obtenga esta info un owner autorizado (que posea el thing)
        $thingWithThingConnected = $this->mergeThingWithThingConnectedByIdHandler->handle(new MergeThingWithThingConnectedByIdCommand($thingId));

        try{
            return new JsonResponse(ThingWithThingConnectedArraySerializer::serialize($thingWithThingConnected));
        }catch (\Exception $e){
            return new JsonResponse($e->getMessage(), 500);
        }

    }
}