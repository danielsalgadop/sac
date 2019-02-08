<?php

namespace App\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SacController extends AbstractController
{
//appId      : '361174884467644',

//version    : 'v3.2'

    /**
     * @Route("/login", name="login", methods={"GET"})
     */
    public function login()
    {
        return $this->render('login.html.twig');
    }

    /**
     * @Route("/loginOk", name="loginOk", methods={"GET"})
     */
    public function loginOk()
    {
        return $this->render('loginOk.html.twig');
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


