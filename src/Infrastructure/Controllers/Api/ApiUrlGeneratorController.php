<?php


namespace App\Infrastructure\Controllers\Api;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Controllers\HasFbSessionController;

class ApiUrlGeneratorController extends AbstractController implements HasFbSessionController
{
    public function urlForThingInfoProvider(Request $request)
    {
        return new JsonResponse($this->generateUrl('thing_info', ['thingId' => $request->get('thingId')]), 200);
    }

    public function urlForApiThingInfoProvider(Request $request)
    {
        return new JsonResponse($this->generateUrl('api_thing_info', ['thingId' => $request->get('thingId')]), 200);
    }

    public function urlForShareActionWithFriend(Request $request)
    {
        return new JsonResponse($this->generateUrl('url_provider_for_api_share_action', ['thingId' => $request->get('thingId'), 'actionId' => $request->get('actionId')]), 200);
    }
}