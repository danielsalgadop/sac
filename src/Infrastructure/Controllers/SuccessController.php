<?php

namespace App\Infrastructure\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SuccessController extends Controller
{
    public function index(Request $request)
    {
//        var_export($errors);
        $message = $request->get('message');
        return new Response("SUCCESS ".$message);
    }
}