<?php

namespace App\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SacController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"GET"})
     */
    public function login()
    {
        return $this->render('login.html.twig');
//        new Response("login with facebook");
    }

    /**
     * @Route("/loginOk", name="loginOk", methods={"GET"})
     */
    public function loginOk()
    {
        return $this->render('loginOk.html.twig');
//        new Response("login with facebook");
    }
}
