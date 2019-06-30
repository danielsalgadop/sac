<?php


namespace App\Infrastructure\Controllers\Api;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiUrlGeneratorController extends AbstractController
{
    public function urlForThingInfoProvider(Request $request)
    {
        return new JsonResponse($this->generateUrl('thing_info', ['thingId' => $request->get('thingId')]), 200);
    }

    public function urlForApiThingInfoProvider(int $ThingId)
    {
        //
    }
}