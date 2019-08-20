<?php


namespace App\Infrastructure\Controllers\Api;


use App\Application\Command\Thing\MergeThingWithThingConnectedByIdCommand;
use App\Application\CommandHandler\Thing\MergeThingWithThingConnectedByIdHandler;
use App\Infrastructure\Controllers\HasFbSessionController;
use App\Infrastructure\Thing\Serializer\ThingWithThingConnectedArraySerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Infrastructure\Owner\Serializer\JsonSerializer;


class ThingApiController extends AbstractController  implements HasFbSessionController
{

    private $mergeThingWithThingConnectedByIdHandler;

    public function __construct(MergeThingWithThingConnectedByIdHandler $mergeThingWithThingConnectedByIdHandler)
    {
        $this->mergeThingWithThingConnectedByIdHandler = $mergeThingWithThingConnectedByIdHandler;
    }

    public function info(int $thingId)
    {
        file_put_contents("/tmp/debug.txt", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export($thingId, true) . PHP_EOL, FILE_APPEND);
        try {
            $thingWithThingConnected = $this->mergeThingWithThingConnectedByIdHandler->handle(new MergeThingWithThingConnectedByIdCommand($thingId));
            return new JsonResponse(ThingWithThingConnectedArraySerializer::serialize($thingWithThingConnected));
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }

    }
}