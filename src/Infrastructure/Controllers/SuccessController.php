<?php

namespace App\Infrastructure\Controllers;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SuccessController extends AbstractController
{
    public function index(Request $request)
    {
        $message = $request->get('message');
        $shareLink = null;
        if($request->get('shareLink')){
            $shareLink =$request->get('shareLink');
        }
        return $this->render('Success/success.twig', ['message' => $message, 'shareLink' => $shareLink]);
    }
}