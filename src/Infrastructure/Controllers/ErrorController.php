<?php

namespace App\Infrastructure\Controllers;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

class ErrorController extends AbstractController
{
    public function index(Request $request)
    {
//        var_export($errors);
        $message = $request->get('message');
        return new Response("ERROR ".$message);
    }
}