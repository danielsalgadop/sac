<?php

namespace App\Infrastructure\Controllers;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

class ErrorController extends AbstractController
{
    public function index(Request $request)
    {
        $message = $request->get('message');
        return $this->render('Error/error.twig',['message' => $message]);
    }
    public function fallback()
    {
        return $this->render('Error/error.twig',['message' => 'Page not found']);
    }
}