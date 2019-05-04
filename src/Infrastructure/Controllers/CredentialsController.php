<?php

namespace App\Infrastructure\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CredentialsController extends Controller
{

    public function test()
    {
        return $this->render('test.html.twig');
    }

    public function handlebars()
    {
        return $this->render('test/handlebars.html.twig');
    }
    //appId      : '361174884467644',
    //version    : 'v3.2'

    public function login()
    {
        // return new Response($cookie);
        // $request->headers->setCookie(new Cookie('Peter', 'Griffin', time() + 3600));

        // correct FbLogin will redirect to owner_index
        return $this->render('login.html.twig', ['login_ok_url' => $this->generateUrl('owner_index'), 'login_ko_url' => $this->generateUrl('login')]);
    }

    /* DEPRECATED, redirection to owner_index directly in fbSdk.html.twig */
    public function loginOk(Request $request)
    {
        // meter en bbdd ID

        return $this->redirectToRoute('owner_index');

        // $request->headers;
        // $ei = $request;
        // return new Response(var_dump($request->headers));
        return $this->render('loginOk.html.twig', ['login_ok_url' => $this->generateUrl('loginOk'), 'login_ko_url' => $this->generateUrl('login')]);
    }


    public function loginStatus()
    {
        return $this->render('loginStatus.html.twig');
    }


    public function privacy()
    {
        return new Response("FB privacy");

    }

    public function conditions()
    {
        return new Response("FB conditions");
    }


}


