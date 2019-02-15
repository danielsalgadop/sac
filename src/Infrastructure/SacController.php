<?php

namespace App\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SacController extends AbstractController
{
//appId      : '361174884467644',

//version    : 'v3.2'

    /**
     * @Route("/", name="login", methods={"GET"})
     */
    public function login()
    {
        // $cookie = new Cookie('Peter', 'Griffin', time() + 3600);
        // return new Response($cookie);
        // $request->headers->setCookie(new Cookie('Peter', 'Griffin', time() + 3600));
        return $this->render('login.html.twig', ['login_ok_url'=> $this->generateUrl('loginOk'), 'login_ko_url'=> $this->generateUrl('login')]);
    }

    /**
     * @Route("/loginOk", name="loginOk", methods={"GET"})
     */
    public function loginOk(Request $request)
    {
        
        // meter en bbdd ID

        // $request->headers;
        // $ei = $request;
        // return new Response(var_dump($request->headers));
        return $this->render('loginOk.html.twig', ['login_ok_url'=> $this->generateUrl('loginOk'), 'login_ko_url'=> $this->generateUrl('login')]);
    }


    /**
     * @Route("/loginStatus", name="loginStatus", methods={"GET"})
     */
    public function loginStatus()
    {
        return $this->render('loginStatus.html.twig');
    }


    /**
     * @Route("/privacy", name="privacy", methods={"GET"})
     */
    public function privacy()
    {
        return new Response("FB privacy");

    }

    /**
     * @Route("/conditions", name="conditions", methods={"GET"})
     */
    public function conditions()
    {
        return new Response("FB conditions");
    }


}


