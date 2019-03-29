<?php


namespace App\Infrastructure\Controllers\Api\Owner;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetBasicInfo
{
    public function do(Request $request)
    {
        return new JsonResponse("toe toe tttto");
    }
}