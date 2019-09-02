<?php


namespace App\Infrastructure\Controllers\Api;


use App\Application\Command\Thing\MergeThingWithThingConnectedByIdCommand;
use App\Application\CommandHandler\Thing\MergeThingWithThingConnectedByIdHandler;
use App\Infrastructure\Controllers\HasFbSessionController;
use App\Infrastructure\Owner\Serializer\JsonSerializer;
use App\Infrastructure\Thing\Serializer\ThingWithThingConnectedArraySerializer;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;


class ThingApiController extends AbstractController implements HasFbSessionController
{

    private $mergeThingWithThingConnectedByIdHandler;

    public function __construct(MergeThingWithThingConnectedByIdHandler $mergeThingWithThingConnectedByIdHandler)
    {
        $this->mergeThingWithThingConnectedByIdHandler = $mergeThingWithThingConnectedByIdHandler;
    }

    public function info(int $thingId)
    {
        try {
            $thingWithThingConnected = $this->mergeThingWithThingConnectedByIdHandler->handle(new MergeThingWithThingConnectedByIdCommand($thingId));
            return new JsonResponse(ThingWithThingConnectedArraySerializer::serialize($thingWithThingConnected));
        } catch (Exception $e) {
            return new JsonResponse($e->getMessage(), 400);
        }

    }
}